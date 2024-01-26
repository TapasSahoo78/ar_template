<?php

namespace App\Http\Controllers\Admin\BusStop;

use App\Contracts\Admin\BusStop\BusStopContract;
use App\Http\Controllers\BaseController;
use App\Models\BusStop;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManageController extends BaseController
{
    private $BusStopContract;
    private $BusStopModel;

    protected  $rules = [
        // 'name' => 'required|string',
        'route_id' => 'required|numeric',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
        'order_column' => 'required|numeric'
    ];

    public function __construct(BusStopContract $BusStopContract, BusStop $BusStopModel)
    {
        $this->BusStopContract = $BusStopContract;
        $this->BusStopModel = $BusStopModel;
    }
    public function index()
    {
        Session::put('page', 'bus-stop');
        // $busStops = $this->BusStopContract->allBusStops();
        $busStops = BusStop::with('route')->orderBy('order_column', 'asc')->get()->groupBy('route_id');
        // dd($busStops);
        return view('admin.pages.busStop.list', compact('busStops'));
    }

    public function addStoreBusStop(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $insert_arry = $request->except(['_token', '_method', 'id']);
                $addRoute = $this->BusStopContract->storeBusStop($insert_arry);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Bus Stop added Successfully!',
                        'redirect'  => route('admin.bus.stop.list')
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
                    200
                );
            }
        }
        Session::put('page', 'bus-stop');
        return view('admin.pages.busStop.add');
    }

    public function editUpdateBusStop(Request $request, $routeId)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $update_arry = request()->except(['_token', '_method', 'id']);

                $updateRoute = $this->BusStopContract->updateBusStop($update_arry, $routeId);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Bus Stop updated Successfully!',
                        'redirect'  => route('admin.bus.stop.list')
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
        Session::put('page', 'bus-stop');
        $routeId = Crypt::decrypt($request->id);
        $busStop = $this->BusStopContract->findBusStop($routeId);
        return view('admin.pages.busStop.edit', compact('busStop'));
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required',
            'keyId'     => 'required',
            'status'    => 'required',
            'table'     => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), '', '');
        }
        try {
            $planId = $request->id;
            if (empty($planId)) {
                return $this->responseJson(false, 200, 'Unable to delete record', '', '');
            } else {
                $isDeleted = BusStop::where('id', $planId)->update([
                    'deleted_at' => Carbon::now()
                ]);
                if (isset($isDeleted) && !empty($isDeleted)) {
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => 'Deleted Successfully!',
                            'redirect'  => route('admin.bus.stop.list'),
                            'postStatus' => $request->status
                        ],
                        200
                    );
                }
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, 'Something Went Terribly Wrong.', '', '');
        }
    }
}
