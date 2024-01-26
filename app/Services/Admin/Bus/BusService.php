<?php

namespace App\Services\Admin\Bus;

use App\Contracts\Admin\Bus\BusContract;
use App\Models\Bus as SELF_MODEL;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Support\Str;

class BusService implements BusContract
{
    public function allBuss()
    {
        return SELF_MODEL::with('getRoute')->latest()->get();
    }
    public function availableBus($data)
    {
        $query = Route::with([
            'getBusStop', 'getBus' => function ($query1) use ($data) {
                $query1->whereTime('from_time', '>', $data['time']);
            },
        ])->where('id', $data['route_id'])->first();
        return $query;
    }


    // public function availableBus($data)
    // {
    //     $query = Route::with([
    //         'getBusStop' => function ($query1) use ($data) {
    //             if (!empty($data['bus_stop_id']) && $data['bus_stop_id'] != Null) {
    //                 $query1->where('id', $data['bus_stop_id']);
    //             }
    //         },
    //         'getBus' => function ($query1) use ($data) {
    //             $query1->whereTime('from_time', '>', $data['time']);
    //         },
    //     ])->where('id', $data['route_id'])->first();
    //     return $query;
    // }

    public function getRoutesWiseBusStop($data)
    {
        //     $query = Route::with([
        //         'getBusStop',
        //         'getBus'
        //     ])->where('id', $data['route_id'])->first();
        //     return $query;
    }

    public function timeWiswavailableBus($data)
    {
        $query = Bus::with('getRoute')->where('from_time', '<=', $data['time'])->get();
        return $query;
    }
    public function availableBusDetails($data)
    {
        $query = Bus::with('getRoute')->where('id', $data['bus_id'])->where('from_time', '<=', $data['time'])->get();
        return $query;
    }
    public function storeBus($data)
    {
        return SELF_MODEL::create($data);
    }
    public function findBus($id)
    {
        return SELF_MODEL::find($id);
    }
    public function updateBus($data, $id)
    {
        $bus = SELF_MODEL::where('id', $id)->first();
        $bus->name = $data['name'];
        $bus->route_id = $data['route_id'];
        $bus->vehicle_no = $data['vehicle_no'];
        $bus->from_time = $data['from_time'];
        $bus->to_time = $data['to_time'];
        $bus->save();
    }
    public function destroyBus($id)
    {
        $clients = SELF_MODEL::find($id);
        $clients->delete();
    }
}
