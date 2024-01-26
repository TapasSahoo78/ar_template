<?php

namespace App\Contracts\Admin\Booking;

interface BookingContract
{
    public function allBooking();
    public function userWiseBookList($id);
    public function addBooking(array $data);
    public function findBooking($id);
    public function updateBooking(array $data, $id);
    public function destroyBooking($id);
    public function availableBooking(array $data);
    public function timeWiswavailableBooking(array $data);
    public function bookingDetails(array $data);
    public function cancelBooking(array $data);
    public function passValidateBooking(array $data);
}
