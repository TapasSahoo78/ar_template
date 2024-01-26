<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Admin\Bus\BusContract;
use App\Contracts\Admin\BusStop\BusStopContract;
use App\Contracts\Admin\Package\PackageContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlansController extends BaseController
{
    private $BusContract;
    private $BusStopContract;
    private $PackageContract;

    public function __construct(PackageContract $PackageContract, BusContract $BusContract, BusStopContract $BusStopContract)
    {
        $this->BusContract = $BusContract;
        $this->PackageContract = $PackageContract;
        $this->BusStopContract = $BusStopContract;
    }
    protected $status = false;
    protected $message;

    public function plansList(Request $request)
    {

        $tokenWithBearer = $request->header('Authorization');

        $token = substr($tokenWithBearer, 7);
        $token = $request->bearerToken();
        $user = (object)[];
        if (isset($token) && !empty($token)) {
            $user = getApiTokenCheck($token);
        }
        $plans = $this->PackageContract->getList();

        $arr = [];
        foreach ($plans as $key => $value) {
            $arr[] = $value;
            $arr[$key]['get_user_plan'] = Subscription::where([
                'plan_id' => $value->id,
                'user_id' => $user->id,
                'status' => 1
            ])->first();
        }
        $data['baseUrl'] = config('arc_config.ASSET_URL') . 'uploads/';
        $data['plan_list'] = $arr;
        // $data['user_plan'] = Subscription::where('user_id', $user->id)->with('userDetails')->first();
        $data['user_plan'] = User::select('id')->where('id', $user->id)->with('getUserSubscription.userDetails', 'getUserSubscription.passCodePlan')->first();
        $message = $data ? "Plans Fetch successfully" : "Something went wrong";
        if ($data) {
            return $this->apiResponseJson(true, 200, $message, $data);
        }
    }
    public function plansDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "plan_id" => "required|numeric"
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }

        try {
            $tokenWithBearer = $request->header('Authorization');

            $token = substr($tokenWithBearer, 7);
            $token = $request->bearerToken();
            $user = (object)[];
            if (isset($token) && !empty($token)) {
                $user = getApiTokenCheck($token);
            }

            $data['plan_details'] = $this->PackageContract->getDetails($request->all());
            $data['subscription_details'] = Subscription::where([
                'plan_id' => $data['plan_details']['id'],
                'user_id' => $user->id,
                'status' => 1
            ])->first();
            $message = $data ? "Plans Details Fetch successfully" : "Something went wrong";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
}
