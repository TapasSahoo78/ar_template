<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Contracts\Admin\Bus\BusContract;
use App\Contracts\Admin\Driver\DriverContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Driver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManageController extends BaseController
{
    private $DriverContract;
    private $BusModel;
    private $BusContract;
    public function __construct(DriverContract $DriverContract, BusContract $BusContract, Bus $BusModel)
    {
        $this->DriverContract = $DriverContract;
        $this->BusModel = $BusModel;
        $this->BusContract = $BusContract;
    }
    public function index()
    {
        Session::put('page', 'driver');
        $drivers = $this->DriverContract->allDriver();
        return view('admin.pages.driver.list', compact('drivers'));
    }
    public function addStoreDriver(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|unique:users,phone',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'authozation_no' => 'required',
                'reg_no' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $insert_arry = request()->except(['_token', '_method', 'id']);
                $addRoute = $this->DriverContract->storeDriver($insert_arry);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Driver added Successfully!',
                        'redirect'  => route('admin.driver.list')
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Something went wrong!!',
                        'redirect'  => ''
                    ],
                    500
                );
            }
        }
        Session::put('page', 'driver');
        return view('admin.pages.driver.add');
    }

    public function editUpdateDriver(Request $request, $driverId)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'password' => 'required',
                'authozation_no' => 'required',
                'reg_no' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $update_arry = request()->except(['_token', '_method', 'id']);

                $updateRoute = $this->DriverContract->updateDriver($update_arry, $driverId);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Driver updated Successfully!',
                        'redirect'  => route('admin.driver.list')
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Something went wrong!!',
                        'redirect'  => ''
                    ],
                    500
                );
            }
        }
        Session::put('page', 'driver');
        $driverId = Crypt::decrypt($request->id);
        $driver = $this->DriverContract->getDriver($driverId);
        return view('admin.pages.driver.edit', compact('driver'));
    }

    /*********************** Assigned Driver Management Start ******************************/
    public function assignelist(Request $request)
    {
        $driver = $this->DriverContract->allDriver();
        $buses = $this->BusContract->allBuss();
        // dd($driver);
        return view('admin.pages.driverAssigned.list', compact('driver', 'buses'));
    }
    public function assigneDriver(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|exists:users,id',
                'busId' => 'required|exists:buses,id',
                // 'date' => 'required|date',
                // 'start_time' => 'required',

            ]);
            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            // dd($request->all());
            DB::beginTransaction();
            try {
                $getBus = Driver::where('bus_id', $request->busId)->first();
                if (empty($getBus)) {
                    $insert_arry = request()->except(['_token', '_method', 'id']);
                    $addRoute = $this->DriverContract->assigneDriver($insert_arry);
                } else {
                    Driver::where('bus_id', $request->busId)->update([
                        'user_id' => $request->driver_id
                    ]);
                }

                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Driver Assigned Successfully!',
                        'redirect'  => route('admin.bus.list')
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Something went wrong!!',
                        'redirect'  => ''
                    ],
                    500
                );
            }
        }
        return view('admin.pages.driverAssigned.add');
    }
}
