<?php

namespace App\Contracts\Admin\BusStop;

interface BusStopContract
{
    public function allBusStops();
    public function storeBusStop(array $data);
    public function findBusStop($id);
    public function updateBusStop(array $data, $id);
    public function destroyBusStop($id);
}
