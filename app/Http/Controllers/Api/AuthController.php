<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\OtpVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use App\Contracts\Auth\AuthContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Auth\OtpResources;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\Auth\LoginApiCollection;
use App\Http\Resources\Api\User\UserResources;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    private $AuthContract;
    private $AdminModel;
    public function __construct(AuthContract $AuthContract, User $AdminModel)
    {
        $this->AuthContract = $AuthContract;
        $this->AdminModel = $AdminModel;
    }
    protected $status = false;
    protected $message;
    // use HasApiTokens;
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email|nullable',
            'phone' => 'sometimes|nullable|digits_between:10,11'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        DB::beginTransaction();
        try {

            $findEmailOrPhone = $this->AuthContract->findEmailOrPhone($request->all());

            if (isset($findEmailOrPhone) && !empty($findEmailOrPhone)) {
                $data = $this->AuthContract->otpSend(['user_id' => $findEmailOrPhone->id]);
                $message = $data ? "Otp send successfully" : "Otp send";
            } else {
                $data = $this->AuthContract->registration($request->all());
                $data = $this->AuthContract->otpSend(['user_id' => $data->id]);
                $message = $data ? "User record saved && Otp send successfully" : "Otp send";
            }
            if (isset($data) && !empty($data)) {
                DB::commit();
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (\Throwable $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function otpVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required',
            // 'phone' => 'required',
            'otp' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        DB::beginTransaction();
        try {
            if (isset($request->email) && !empty($request->email)) {
                $user = User::select('id', 'name', 'email', 'phone', 'is_profile')->where('email', $request->email)->first();
            } else {
                $user = User::select('id', 'name', 'email', 'phone', 'is_profile')->where('phone', $request->phone)->first();
            }
            if ($user) {
                $otpVerify = OtpVerify::where([
                    'user_id' => $user->id,
                    'otp' => $request->otp
                ])->first();
                if (isset($otpVerify) && !empty($otpVerify)) {
                    // OTP is verified, delete the OTP record
                    $otpVerify->forceDelete();
                    // Create a new access token using Laravel Passport
                    $token = $user->createToken('Laravel Password Grant Client');
                    // Access the generated token
                    $accessToken = $token->accessToken;
                    $otpVerify = User::where('id', $user->id)->update([
                        'access_token' => $accessToken,
                        'is_profile' => 1,
                    ]);
                    DB::commit();
                    return response()->json([
                        'message' => 'Otp Verified Successfully',
                        'status' => true,
                        'response_code' => 200,
                        'access_token' => $accessToken,
                        'token_type' => 'Bearer',
                        'created_at' => now(),
                        'expires_at' => $token->token->expires_at,
                        'user' => $user
                    ]);
                } else {
                    return $this->apiResponseJson(false, 200, 'Otp not found!', (object) []);
                }
            }
        } catch (\Throwable $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function otpVerifyOld(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $otpVerify = OtpVerify::where([
                    'user_id' => $user->id,
                    'otp' => $request->otp
                ])->first();
                if ($otpVerify) {
                    $otpVerify->forceDelete();
                    return $this->apiResponseJson(true, 200, 'Successfully logged in', new LoginApiCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, "Otp doesn't match", (object) []);
                }
            } else {
                return $this->apiResponseJson(false, 404, 'User not found', (object) []);
            }
        } catch (\Throwable $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function userProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (isset($user) && !empty($user)) {
                $message = $user ? "User Details" : "Something went wrong";
                $data['user'] = $user;
                $data['base_url'] = asset('uploads');
                DB::commit();
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (\Throwable $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function updateProfile(Request $request)
    {
        $user = $request->user_id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'image' => 'image|mimes:jpeg,png,gif|max:2048',
            'email' => 'sometimes||nullable|email|unique:users,email,' . $user,
            'phone' => 'sometimes|nullable|numeric|unique:users,phone,' . $user,
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        DB::beginTransaction();
        try {
            $imageName = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $imageName);
            }
            $user = User::where('id', $request->user_id)->first();
            if (isset($user) && !empty($user)) {
                $updateData = User::where('id', $request->user_id)->first();
                $updateData->name = $request->name;
                $updateData->last_name = $request->last_name;
                $updateData->gender = $request->gender;
                $updateData->image = $imageName ? $imageName : $user->image;
                $updateData->phone = $request->phone ? $request->phone : $user->phone;
                $updateData->email = $request->email ? $request->email : $user->email;
                $updateData->is_profile = 1;
                $updateData->save();
                $message = $updateData ? "User Profile Update successfully" : "Something went wrong";
            }
            if (isset($updateData)) {
                DB::commit();
                return $this->apiResponseJson(true, 200, $message, $updateData);
            }
        } catch (\Throwable $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function logout(Request $request)
    {
        try {
            $token = User::where('id', $request->user_id)->update(['access_token' => '']);
            return $this->apiResponseJson(true, 200, 'You have been successfully logged out', (object) []);
        } catch (\Exception $e) {
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, "Something Went Wrong");
        }
    }
    // **********************************************************************************
    // ************************Driver****************************************************
    // **********************************************************************************

    public function driverLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        DB::beginTransaction();
        try {
            if (Auth::attempt($request->only(['email', 'password']))) {
                $user = auth()->user();
                if (!$user->hasRole('driver')) {
                    auth()->logout();
                    return $this->responseJson(false, 200, 'Sorry you are not a driver', []);
                }
                $user['token'] = $user->createToken('Laravel Password Grant Client');
                // Access the generated token
                $accessToken = $user['token']->accessToken;

                $isUpdateToken = User::where('id', $user->id)->update([
                    'access_token' => $accessToken
                ]);
                DB::commit();
                return $this->responseJson(true, 200, 'User Login Successfully', new UserResources($user));
            } else {
                return $this->responseJson(false, 200, 'Incorrect User Type Please try again',  (object) []);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
//
