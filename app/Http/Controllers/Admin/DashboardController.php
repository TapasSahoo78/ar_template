<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\Plan;
use App\Models\Route;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        Session::put('page', 'dashboard');
        $data['total_passes'] = Plan::count();
        $data['total_user'] = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->count();
        $data['total_subscription'] = Subscription::count();
        $data['total_routes'] = Route::count();
        $data['total_bus_stops'] = BusStop::count();
        $data['total_buses'] = Bus::count();
        return view('admin.pages.dashboard', compact('data'));
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required',
            'keyId'     => 'required',
            'status'    => 'required',
            'table'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => FALSE,
                    'message'   => $validator->errors()->first(),
                    'redirect'  => ''
                ],
                200
            );
        }
        try {
            DB::table($request->table)->where($request->keyId, $request->id)->update(['status' => $request->status]);
            return response()->json(
                [
                    'status'    => TRUE,
                    'message'   => 'Status updated successfully',
                    'redirect'  => "",
                    'postStatus' => $request->status
                ],
                200
            );
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return response()->json([
                'status'    => FALSE,
                'message'   => 'Something Went Terribly Wrong.',
                'redirect'  => ''
            ], 500);
        }
    }
}
