<?php

namespace App\Services\Transaction;

use App\Contracts\Subscription\SubscriptionContract;
use App\Contracts\Transaction\TransactionContract;
use App\Models\User\Booking as SELF_MODEL;
use App\Models\Bus;
use App\Models\Subscription;
use App\Models\Route;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionService implements TransactionContract
{

    public function addTransaction($data)
    {
        // dd($data);
        $query = Transaction::create([
            'plan_id' => $data['plan_id'],
            'user_id' => $data['user_id'],
            'buy_date' => $data['buy_date'],
            'transaction_no' => $data['transaction_no'],
            'status' => $data['status'] == 'succeeded' ? 1 : 2,
        ]);
        return $query;
    }
    // public function updatePurchasePlan($data)
    // {
    //     $updateSubscription = Subscription::where('user_id', $data['user_id'])->where('id', $data['id'])->first();
    //     $updateSubscription->plan_id = $data['plan_id'];
    //     $updateSubscription->buy_date = $data['buy_date'];
    //     $updateSubscription->duration = $data['duration'];
    //     $updateSubscription->expiry_date = $data['expiry_date'];
    //     $updateSubscription->save();
    //     return $updateSubscription;
    // }
    // public function findSubscriptionId($id)
    // {
    //     return Subscription::where('user_id', $id)->first();
    // }
}


// "plan_id" => 1
//   "user_id" => 22
//   "buy_date" => "2023-01-04"
//   "transaction_no" => "AEFEDR987654323456"
//   "status" => "success"
