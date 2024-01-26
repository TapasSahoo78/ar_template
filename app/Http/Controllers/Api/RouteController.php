<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Admin\Bus\BusContract;
use App\Contracts\Admin\BusStop\BusStopContract;
use App\Contracts\Admin\Route\RouteContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Route\RouteResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RouteController extends BaseController
{
    private $RouteContract;
    private $BusContract;
    private $BusStopContract;

    public function __construct(RouteContract $RouteContract, BusContract $BusContract, BusStopContract $BusStopContract)
    {
        $this->RouteContract = $RouteContract;
        $this->BusContract = $BusContract;
        $this->BusStopContract = $BusStopContract;
    }
    protected $status = false;
    protected $message;

    public function routeList(Request $request)
    {
        try {
            $data['routes'] = $this->RouteContract->getAllRoutes();
            $data['bus'] = $this->BusContract->allBuss();
            $data['busStop'] = $this->BusStopContract->allBusStops();
            $message = $data ? "Route Fetch successfully" : "Something went wrong";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }


    public function availableBusStop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|numeric',
            // 'time' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        try {
            $data = $this->BusContract->getRoutesWiseBusStop($request->all());
            $message = $data ? "Bus  Fetch successfully" : "Something went wrong";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function availableBus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|numeric',
            // 'time' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        try {
            $data = $this->BusContract->availableBus($request->all());
            $message = $data ? "Bus  Fetch successfully" : "Something went wrong";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function timeWiseAvailableBus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }

        try {
            $data = $this->BusContract->timeWiswavailableBus($request->all());
            $message = $data ? "Time Wise Bus Fetch successfully" : "Something went wrong";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function BusDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bus_id" => "required|numeric",
            'time' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }

        try {
            $data = $this->BusContract->availableBusDetails($request->all());
            $message = $data ? "Bus Details Fetch successfully" : "Something went wrong";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
}
