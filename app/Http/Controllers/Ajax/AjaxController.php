<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\BaseController;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\TimeTableStop;
use Illuminate\Http\Request;

class AjaxController extends BaseController
{
    protected $data, $fileName, $object, $errormsg;
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchBus(Request $request)
    {
        $data['bus'] = Bus::where("route_id", $request->route_id)->get(["name", "id"]);
        $data['bus_stop'] = BusStop::where("route_id", $request->route_id)->get(["name", "id"]);
        return response()->json($data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchBusTime(Request $request)
    {
        $data['bus_time'] = Bus::where("id", $request->bus_id)->first(["name", "id", "from_time", "to_time"]);
        return response()->json($data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchTimeTableStop(Request $request)
    {
        $data['timetable'] = TimeTableStop::where([
            'route_id' => $request->route,
            'bus_id' => $request->bus,
            'week_days' => $request->week
        ])->get();
        return response()->json($data);
    }
}
