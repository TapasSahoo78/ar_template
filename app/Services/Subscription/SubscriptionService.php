<?php

namespace App\Services\Subscription;

use App\Contracts\Subscription\SubscriptionContract;
use App\Models\User\Booking as SELF_MODEL;
use App\Models\Bus;
use App\Models\Subscription;
use App\Models\Route;
use Illuminate\Support\Str;

class SubscriptionService implements SubscriptionContract
{

    public function purchasePlan($data)
    {
        $query = Subscription::create([
            'plan_id' => $data['plan_id'],
            'user_id' => $data['user_id'],
            'buy_date' => $data['buy_date'],
            'transaction_id' => $data['transaction_id'],
            'duration' => $data['duration'],
            'expiry_date' => $data['expiry_date'],
            'daily_ride' => $data['daily_ride'],
            'total_ride' => $data['total_ride']
        ]);
        return $query;
    }
    public function updatePurchasePlan($data)
    {
        $updateSubscription = Subscription::where('user_id', $data['user_id'])->where('id', $data['id'])->first();
        $updateSubscription->plan_id = $data['plan_id'];
        $updateSubscription->buy_date = $data['buy_date'];
        $updateSubscription->duration = $data['duration'];
        $updateSubscription->expiry_date = $data['expiry_date'];
        $updateSubscription->daily_ride = $data['daily_ride'];
        $updateSubscription->total_ride = $data['total_ride'];
        $updateSubscription->save();
        return $updateSubscription;
    }
    public function findSubscriptionId($id)
    {
        return Subscription::where('user_id', $id)->first();
    }
}
