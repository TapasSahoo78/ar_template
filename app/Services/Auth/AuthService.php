<?php

namespace App\Services\Auth;

use App\Models\Admin;
use App\Models\User as SELF_MODEL;
use App\Contracts\Auth\AuthContract;
use App\Models\OtpVerify;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthContract
{

    public function findEmail(array $data)
    {
        $query = SELF_MODEL::where('email', $data['email'])->first();
        return $query;
    }
    public function findEmailOrPhone(array $data)
    {
        if ($data['email']) {
            $query = SELF_MODEL::where('email', $data['email'])->first();
        } else {
            $query = SELF_MODEL::where('phone', $data['phone'])->first();
        }


        return $query;
    }
    public function signup()
    {
        return "signup";
    }
    public function login(array $request, $model)
    {
        $userCredentials = array(
            'email' => $request['email'],
            'password' => $request['password'],
        );
        $user = $model::where('email', $request['email'])->first();
        $remember = isset($request['remember_me']) ? true : false;
        $login = Auth::attempt($userCredentials, $remember);

        if ($login) {
            return true;
        }
    }
    public function logout($guard)
    {
        $logout = Auth::logout();
        return $logout;
    }

    public function registration(array $data)
    {
        $user_role = Role::where('slug', 'user')->first();
        $data['customer_id'] = SELF_MODEL::generateCustBookingNo();

        $query = SELF_MODEL::create($data);
        $query->roles()->attach($user_role);
        return $query;
    }

    public function findId($data)
    {
        $query = OtpVerify::where('user_id', $data)->first();
        return $query;
    }
    public function otpSend(array $data)
    {

        $digits = 4;
        $otp = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $findId = $this->findId($data['user_id']);
        if (isset($findId) && !empty(($findId))) {
            $query = OtpVerify::where('id', $findId->id)->first();
            $query->otp = $otp;
            $query->save();
        } else {
            $query = OtpVerify::create([
                'user_id' => $data['user_id'],
                'otp' => $otp
            ]);
        }
        return $query;
    }
}
