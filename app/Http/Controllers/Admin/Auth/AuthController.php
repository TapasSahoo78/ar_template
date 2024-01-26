<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Contracts\Auth\AuthContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    private $AuthContract;
    private $AdminModel;

    public function __construct(AuthContract $AuthContract, User $AdminModel)
    {
        $this->AuthContract = $AuthContract;
        $this->AdminModel = $AdminModel;
    }
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6'
    ];

    protected $status = false;
    protected $message;
    public function showAdminLoginForm()
    {
        return view('admin.pages.login');
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first());
        }
        try {

            $adminLogin = $this->AuthContract->login($request->all(), $this->AdminModel);

            if ($adminLogin) {
                return $this->responseJson(true, 200, config('custom.MSG_RECORD_LOGIN_SUCCESS'), '', route('admin.dashboard'));
            } else {
                return $this->responseJson(false, 200, config('custom.MSG_RECORD_LOGIN_FAILED'), '', '');
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, config('custom.MSG_ERROR_TRY_AGAIN'), '', '');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $this->AuthContract->logout('admin');
            return redirect()->route('admin.login');
        }
    }
}
