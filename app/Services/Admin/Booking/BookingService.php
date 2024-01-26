<?php

namespace App\Services\Admin\Booking;

use App\Contracts\Admin\Booking\BookingContract;
use App\Models\User\Booking as SELF_MODEL;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Support\Str;

class BookingService implements BookingContract
{

    public function allBooking()
    {
        return SELF_MODEL::where('status', 0)->orderBy('id', 'DESC')->get();
    }
    public function userWiseBookList($data)
    {
        $query = SELF_MODEL::where('user_id', $data)->with('bus', 'busRout', 'busStop')->where('status', 0)->orderBy('id', 'DESC')->get();
        return $query;
    }
    public function addBooking($data)
    {
        return SELF_MODEL::create($data);
    }
    public function findBooking($id)
    {
    }
    public function updateBooking($data, $id)
    {
    }
    public function destroyBooking($id)
    {
    }
    public function availableBooking($data)
    {
    }
    public function timeWiswavailableBooking($data)
    {
    }
    public function bookingDetails($data)
    {
    }

    public function cancelBooking($data)
    {
        $query = SELF_MODEL::where([
            'user_id' => $data['user_id'],
            'id' => $data['booking_id']
        ])->first();
        $query->status = $data['status'];
        $query->save();
        return $query;
    }

    public function passValidateBooking($data)
    {
        $query = SELF_MODEL::where([
            'user_id' => $data['user_id'],
            'id' => $data['booking_id']
        ])->first();
        $query->is_validate = $data['is_validate'];
        $query->save();
        return $query;
    }
}
