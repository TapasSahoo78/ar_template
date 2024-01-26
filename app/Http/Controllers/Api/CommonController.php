<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\HelpAndSupport;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends BaseController
{
    public function termConditionPrivacyPolicy(Request $request)
    {
        try {
            $data['termCondition'] = HelpAndSupport::get();
            $data['privacyPolicy'] = PrivacyPolicy::get();
            if (count($data) > 0) {
                $message = "Term Condition and Privacy Policy";
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (\Throwable $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
}
