<?php

namespace App\Contracts\Subscription;

interface SubscriptionContract
{
    public function purchasePlan(array $data);
    public function updatePurchasePlan(array $data);
    //     public function userWiseBookList($id);
    //     public function addBooking(array $data);
    //     public function findBooking($id);
    //     public function updateBooking(array $data, $id);
    public function findSubscriptionId($id);
    //     public function availableBooking(array $data);
    //     public function timeWiswavailableBooking(array $data);
    //     public function bookingDetails(array $data);
}
