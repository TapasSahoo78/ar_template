<?php

namespace App\Services\Admin\Driver;

use App\Contracts\Admin\Driver\DriverContract;
use App\Models\Driver;
use App\Models\Role;
use App\Models\User as SELF_MODEL;
use App\Models\User;
use DateTime;
use Illuminate\Support\Str;

class DriverService implements DriverContract
{

    public function allDriver()
    {
        $query = getUserList('driver');
        return $query;
    }

    public function storeDriver($data)
    {
        $image = isset($data['img']) ? fileUpload($data['img']) : '';

        $data = SELF_MODEL::create([
            'customer_id' => SELF_MODEL::generateDriverBookingNo(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'image' => $image,
            'authozation_no' => $data['authozation_no'],
            'reg_no' => $data['reg_no']
        ]);

        $driver_role = Role::where('slug', 'driver')->first();
        $data->roles()->attach($driver_role);

        return $data;
    }
    public function updateDriver($data, $id)
    {
        $image = isset($data['img']) ? fileUpload($data['img']) : '';
        $driver = SELF_MODEL::where('id', $id)->first();
        $driver->name = $data['name'];
        $driver->email = $data['email'];
        $driver->phone = $data['phone'];
        $driver->password = $data['password'];
        $driver->image = $image;
        $driver->authozation_no = $data['authozation_no'];
        $driver->reg_no = $data['reg_no'];
        $driver->save();
    }

    public function getDriver($id)
    {
        return SELF_MODEL::find($id);
    }

    public function findDriver($id)
    {
        $dt = new DateTime();
        $date = $dt->format('Y-m-d');
        // return Driver::with('getBus', 'getUser', 'getBus.getRoute')->where('user_id', $id)->where('status', 0)->get();
        return Driver::with('getBus', 'getUser', 'getBus.getRoute')->where('user_id', $id)->first();
    }

    // public function updateBusStop($data, $id)
    // {
    //     $busStops = SELF_MODEL::where('id', $id)->first();
    //     $busStops->name = $data['name'];
    //     $busStops->save();
    // }

    // public function destroyBusStop($id)
    // {
    //     $clients = SELF_MODEL::find($id);
    //     $clients->delete();
    // }

    public function coordinateUpdate($data)
    {
        $data = User::where('id', $data['user_id'])->update([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);
        return $data;
    }

    public function assigneDriver($data)
    {
        $data = Driver::create([
            'user_id' => $data['driver_id'],
            'bus_id' => $data['busId'],
            // 'date' => $data['date'],
            // 'start_time' => $data['start_time'],
            // 'end_time' => $data['end_time'],
        ]);
        return $data;
    }
}
