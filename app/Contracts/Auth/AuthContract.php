<?php

namespace App\Contracts\Auth;

interface AuthContract
{
    public function signup();
    public function login(array $data, $model);
    public function logout($guard);
    public function registration(array $data);
    public function findEmail(array $data);
    public function findEmailOrPhone(array $data);
    public function otpSend(array $data);
    public function findId($data);
}
