<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Admin\Booking\BookingContract;
use App\Contracts\Admin\Package\PackageContract;
use App\Contracts\Subscription\SubscriptionContract;
use App\Contracts\Transaction\TransactionContract;
use App\Http\Controllers\BaseController;
use App\Models\BusStop;
use Carbon\Carbon;
use Exception;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends BaseController
{
    private $BusStopModel;
    private $BookingContract;
    private $SubscriptionContract;
    private $PackageContract;
    private $TransactionContract;

    public function __construct(TransactionContract $TransactionContract, SubscriptionContract $SubscriptionContract, PackageContract $PackageContract, BusStop $BusStopModel, BookingContract $BookingContract)
    {
        $this->BusStopModel = $BusStopModel;
        $this->BookingContract = $BookingContract;
        $this->SubscriptionContract = $SubscriptionContract;
        $this->PackageContract = $PackageContract;
        $this->TransactionContract = $TransactionContract;
    }

    public function subscribePass(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                "plan_id" =>  'required',
                "user_id" =>  'required',
                "buy_date" => 'required',
                "stripe_token" => 'required',
                "currency" => 'required'
            ]);
            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {

                $findPlan = $this->PackageContract->getDetails($request->all());

                // $date = Carbon::now(); // Get the current date
                // $oneMonthLater = $date->addMonth($findPlan->duration);

                $oneMonthLater = packageExpiryDate($request->buy_date, $findPlan->duration);

                $findSubscriptionId = $this->SubscriptionContract->findSubscriptionId($request->user_id);
                //-----------------------------------------------------------------------------------------------------------
                $paymentData = $this->makeStripePaymet($findPlan, $request);
                // dd($paymentData->status);
                //-----------------------------------------------------------------------------------------------------------
                if ($paymentData->status == "succeeded") {
                    $request['transaction_no'] = $paymentData->balance_transaction;
                    $request['status'] = true;
                    $addTransaction = $this->TransactionContract->addTransaction($request->except('_token'));

                    if (isset($findSubscriptionId) && !empty($findSubscriptionId)) {
                        $request->merge(['transaction_id' => $addTransaction->id, 'buy_date' => $request->buy_date, 'duration' => $findPlan->duration, 'expiry_date' => $oneMonthLater, 'id' => $findSubscriptionId->id, 'daily_ride' => $findPlan->daily_ride, 'total_ride' => $findPlan->total_ride]);
                        $data = $this->SubscriptionContract->updatePurchasePlan($request->except('_token'));
                        $message = 'Purchase Plan Updated Successfully!';
                    } else {
                        $request->merge(['transaction_id' => $addTransaction->id, 'buy_date' => $request->buy_date, 'duration' => $findPlan->duration, 'expiry_date' => $oneMonthLater, 'daily_ride' => $findPlan->daily_ride, 'total_ride' => $findPlan->total_ride]);
                        $data = $this->SubscriptionContract->purchasePlan($request->except('_token'));
                        $message = 'Purchase Plan added Successfully!';
                    }
                } else {
                    $request['transaction_no'] = $paymentData->balance_transaction;
                    $data = $this->TransactionContract->addTransaction($request->except('_token'));
                    $message = 'Purchase Plan added Successfully!';
                }
                $data['paymentData'] = $paymentData;
                if ($data) {
                    DB::commit();
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => $message,
                            'data'  => $data
                        ],
                        200
                    );
                }
            } catch (Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Something went wrong!!',
                        'redirect'  => ''
                    ],
                    200
                );
            }
        }
    }

    public function makeStripePaymet($planData, $data)
    {
        $stripe = new StripeClient(config('arc_config.STRIPE_SECRET_KEY'));
        // Create a charge
        $charge = $stripe->charges->create([
            'amount' => (float)$planData->price * 100,
            'currency' => $data['currency'],
            'source' => $data['stripe_token'],
            'description' => $data['user_id']
        ]);

        return $charge;
    }
}
