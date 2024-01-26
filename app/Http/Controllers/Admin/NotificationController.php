<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function notification()
    {
        Session::put('page', 'notification');
        return view('admin.pages.notification.notification');
    }
}
