<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Hobbies;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\FamilyDetails;
use App\Models\ProfileBasicDetail;
use App\Models\ReligiousInformation;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfessionalInformation;
use App\Contracts\Admin\Package\PackageContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Auth\AuthContract;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Contracts\Admin\Booking\BookingContract;
use App\Contracts\Subscription\SubscriptionContract;
use App\Contracts\Transaction\TransactionContract;
use App\Models\BusStop;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class UserController extends BaseController
{
    private $BusStopModel;
    private $BookingContract;
    private $PackageContract;

    private $SubscriptionContract;
    private $TransactionContract;

    public function __construct(TransactionContract $TransactionContract, SubscriptionContract $SubscriptionContract, PackageContract $PackageContract, BusStop $BusStopModel, BookingContract $BookingContract)
    {
        $this->BusStopModel = $BusStopModel;
        $this->BookingContract = $BookingContract;
        $this->SubscriptionContract = $SubscriptionContract;
        $this->PackageContract = $PackageContract;
        $this->TransactionContract = $TransactionContract;
    }
    public function index()
    {
        Session::put('page', 'user');
        $data = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->latest()->get();
        return view('admin.pages.user.list', compact("data"));
    }

    public function userDetails(Request $request, $id)
    {
        Session::put('page', 'user');
        $data['users_details'] = User::where('id', $request->id)->first();
        $data['subscription'] = Subscription::where('user_id', $request->id)->with('passCodePlan', 'userDetails')->latest()->get();
        return view('admin.pages.user.user-details', compact('data'));
    }

    public function subscriptionList(Request $request)
    {
        Session::put('page', 'user');
        $subscription = Subscription::with('passCodePlan', 'userDetails')->get();

        return view('admin.pages.user.subcription_list', compact('subscription'));
    }

    public function newCustomer(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                // 'last_name' => 'required|string',
                'gender' => 'required|in:male,female,other',
                // 'image' => 'image|mimes:jpeg,png,gif|max:2048',
                'email' => 'sometimes|nullable|email|unique:users,email',
                'phone' => 'sometimes|nullable|numeric|unique:users,phone'
            ]);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $addCustomer = new User();
                $addCustomer->name = $request->name;
                $addCustomer->last_name = $request->last_name;
                $addCustomer->gender = $request->gender;
                $addCustomer->email = $request->email;
                $addCustomer->phone = $request->phone;
                $addCustomer->save();

                $user_role = Role::where('slug', 'user')->first();
                $addCustomer->roles()->attach($user_role);

                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'New user added Successfully!',
                        'redirect'  => route('admin.user.list')
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Something went wrong!!',
                        'redirect'  => ''
                    ],
                    500
                );
            }
        }
        return view('admin.pages.user.add_customer');
    }

    public function getbusPasscode($id)
    {
        $data['buyer_id'] = $id;
        $data['plans'] = $this->PackageContract->getList();
        return view('admin.pages.user.buy_pass', compact('data'));
    }

    public function buyPasscodePage($user_id, $plan_id)
    {
        // echo $user_id . '|' . $plan_id . '|' . $buy_date . '|' . $subtotal . '|' . $currency;
        // echo $number . '|' . $exp_month . '|' . $exp_year . '|' . $cvc;

        return view('admin.pages.user.buy_my_pass', compact('user_id', 'plan_id'));
    }

    public function buyPasscode(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                "plan_id" =>  'required',
                "user_id" =>  'required',
                "buy_date" => 'required',

                "subtotal" => 'required',
                "currency" => 'required',

                'number' => 'required',
                'exp_month' => 'required',
                'exp_year' => 'required',
                'cvc' => 'required'
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
                // $paymentData = $this->makeStripePaymet($findPlan, $request);
                // dd($paymentData->status);

                $carddata = $this->make_stripe_token($request);

                $token = $carddata;

                $paymentData = $this->make_stripe_paymet($request, $token);

                //-----------------------------------------------------------------------------------------------------------
                if (json_decode($paymentData)->status == 'succeeded') {
                    $request['transaction_no'] = json_decode($paymentData)->balance_transaction;
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
                    $request['transaction_no'] = json_decode($paymentData)->balance_transaction;
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
                            'data'  => $data,
                            'redirect'  => route('admin.user.details', $request->user_id)
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

    public function make_stripe_token($request)
    {
        $url = 'https://api.stripe.com/v1/tokens';
        $key_secret = config('arc_config.STRIPE_SECRET_KEY');
        //cURL Request
        $ch = curl_init();
        $card = array('card' => array(
            'number' => $request->number,
            'exp_month' => $request->exp_month,
            'exp_year' => $request->exp_year,
            'cvc' => $request->cvc,
        ));
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        $params = http_build_query($card);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $output = curl_exec($ch);
        return json_decode($output, true);
    }

    public function make_stripe_paymet($request, $token)
    {
        // dd($token);
        $url = 'https://api.stripe.com/v1/charges';
        $key_secret = config('arc_config.STRIPE_SECRET_KEY');
        //cURL Request
        $ch = curl_init();
        $card = array(
            // 'amount' => floatval($request->subtotal),   number_format("1000000",2)
            'amount' => (float)$request->subtotal * 100,
            'currency' => 'usd',
            'source' => $token['id'],
            'description' => rand(),
        );
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        $params = http_build_query($card);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $output = curl_exec($ch);
        return $output;
    }
}
