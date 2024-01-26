<?php

namespace App\Contracts\Admin\Driver;

interface DriverContract
{
    public function allDriver();
    public function storeDriver(array $data);

    public function getDriver($id);
    public function updateDriver(array $data, $id);
    public function assigneDriver(array $data);
    public function coordinateUpdate(array $data);
    public function findDriver($id);
    // public function findBusStop($id);
    // public function updateBusStop(array $data, $id);
    // public function destroyBusStop($id);
}
