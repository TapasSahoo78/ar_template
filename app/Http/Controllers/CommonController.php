<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends BaseController
{
    public function privacyPolicyContent()
    {
        return view('user.pages.privacy-policy');
    }

    public function termConditionContent()
    {
        return view('user.pages.term-condition');
    }
}
