<?php

namespace App\Contracts\Admin\Bus;

interface BusContract
{
    public function allBuss();
    public function storeBus(array $data);
    public function findBus($id);
    public function updateBus(array $data, $id);
    public function destroyBus($id);
    public function availableBus(array $data);
    public function getRoutesWiseBusStop(array $data);
    public function timeWiswavailableBus(array $data);
    public function availableBusDetails(array $data);
}
