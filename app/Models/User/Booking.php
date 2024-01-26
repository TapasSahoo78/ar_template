<?php

namespace App\Models\User;

use App\Models\Bus;
use App\Models\BusStop;
use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function generateBookingNo()
    {
        $last_booking_rqst = Booking::orderBy('id', 'desc')->first();
        $booking_no = str_replace('IB', '', !empty($last_booking_rqst) ? $last_booking_rqst->booking_no : 0);

        if ($booking_no == 0) {
            $request_id = 'IB00000001';
        } else {
            $request_id = 'IB' . sprintf("%07d", $booking_no + 1);
        }

        return $request_id;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->booking_no = (string)Booking::generateBookingNo();
        });
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
    public function busRout()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
    public function busStop()
    {
        return $this->belongsTo(BusStop::class, 'bus_stop_id');
    }
}
