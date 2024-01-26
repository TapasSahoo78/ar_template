<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json(
            [
                'status' => false,
                'response_code' => 401,
                'error' => 'Unauthenticated',
                'message' => 'Please provide a valid token',
            ],
            401
        ));
    }
}
