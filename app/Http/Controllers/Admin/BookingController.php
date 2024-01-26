<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookingController extends BaseController
{
    public function index(Request $request)
    {
        Session::put('page', 'booking');
        $data['booking'] = Booking::with('users', 'bus', 'busRout', 'busStop')->get();
        return view('admin.pages.user.booking_list', compact('data'));
    }
}
