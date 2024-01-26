<?php

namespace App\Http\Controllers\Admin\Bus;

use App\Contracts\Admin\Bus\BusContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManageController extends BaseController
{
    private $BusContract;
    private $BusModel;

    protected  $rules = [
        'name' => 'required|string',
        'route_id' => 'required|numeric',
        'vehicle_no' => 'required|string',
        'from_time' => 'required',
        'to_time' => 'required',
    ];

    public function __construct(BusContract $BusContract, Bus $BusModel)
    {
        $this->BusContract = $BusContract;
        $this->BusModel = $BusModel;
    }
    public function index()
    {
        Session::put('page', 'bus');
        $buses = $this->BusContract->allBuss();
        return view('admin.pages.bus.list', compact('buses'));
    }

    public function addStoreBus(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                // dd($request);
                $insert_arry = request()->except(['_token', '_method', 'id']);
                $addRoute = $this->BusContract->storeBus($insert_arry);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Bus added Successfully!',
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
        Session::put('page', 'bus');
        return view('admin.pages.bus.add');
    }

    public function editUpdateBus(Request $request, $routeId)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $update_arry = request()->except(['_token', '_method', 'id']);

                $updateRoute = $this->BusContract->updateBus($update_arry, $routeId);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Bus updated Successfully!',
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
        Session::put('page', 'bus');
        $busId = Crypt::decrypt($request->id);
        $bus = $this->BusContract->findBus($busId);
        return view('admin.pages.bus.edit', compact('bus'));
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
                $isDeleted = Bus::where('id', $planId)->update([
                    'deleted_at' => Carbon::now()
                ]);
                if (isset($isDeleted) && !empty($isDeleted)) {
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => 'Deleted Successfully!',
                            'redirect'  => route('admin.bus.list'),
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
