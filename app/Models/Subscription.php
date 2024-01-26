<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function generateBookingNo()
    {
        $last_booking_rqst = Subscription::orderBy('id', 'desc')->first();
        $subscription_no = str_replace('ARCO', '', !empty($last_booking_rqst) ? $last_booking_rqst->subscription_no  : 0);
        if ($subscription_no == 0) {
            $request_id = 'ARCO0000001';
        } else {
            $request_id = 'ARCO' . sprintf("%07d", $subscription_no + 1);
        }
        return $request_id;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->subscription_no = (string) Subscription::generateBookingNo();
        });
    }

    public function passCodePlan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
