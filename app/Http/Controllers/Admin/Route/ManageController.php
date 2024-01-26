<?php

namespace App\Http\Controllers\Admin\Route;

use App\Contracts\Admin\Route\RouteContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Route;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageController extends BaseController
{
    private $RouteContract;
    private $RouteModel;

    protected  $rules = [
        'name' => 'required|string',
        'color' => 'required|string'
    ];

    public function __construct(RouteContract $RouteContract, Route $RouteModel)
    {
        $this->RouteContract = $RouteContract;
        $this->RouteModel = $RouteModel;
    }
    public function index()
    {
        Session::put('page', 'route');
        $routes = $this->RouteContract->allRoutes();
        return view('admin.pages.route.list', compact('routes'));
    }

    public function addStoreRoute(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $insert_arry = request()->except(['_token', '_method', 'id']);
                $addRoute = $this->RouteContract->storeRoute($insert_arry);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Route added Successfully!',
                        'redirect'  => route('admin.route.list')
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
        Session::put('page', 'route');
        return view('admin.pages.route.add');
    }

    public function editUpdateRoute(Request $request, $routeId)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $update_arry = request()->except(['_token', '_method', 'id']);

                $updateRoute = $this->RouteContract->updateRoute($update_arry, $routeId);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Route updated Successfully!',
                        'redirect'  => route('admin.route.list')
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
        Session::put('page', 'route');
        $routeId = Crypt::decrypt($request->id);
        $route = $this->RouteContract->findRoute($routeId);
        return view('admin.pages.route.edit', compact('route'));
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
                $isDeleted = Route::where('id', $planId)->update([
                    'deleted_at' => Carbon::now()
                ]);
                if (isset($isDeleted) && !empty($isDeleted)) {
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => 'Deleted Successfully!',
                            'redirect'  => route('admin.route.list'),
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
