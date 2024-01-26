<?php

namespace App\Http\Controllers\Admin\Timetable;

use App\Contracts\Admin\Bus\BusContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\TimeTableStop;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageController extends BaseController
{
    private $BusContract;
    private $BusModel;

    protected $rules = [
        'route_id' => 'required|string',
        'bus_id' => 'required|numeric',
        'week_days' => ['required', 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday'],
        'bus_stop_id.*' => 'required|integer',
        'time_with_stop.*' => 'required',
        // 'bus_stop_id' => 'required',
        // 'time_with_stop' => 'required'
    ];

    public function __construct(BusContract $BusContract, Bus $BusModel)
    {
        $this->BusContract = $BusContract;
        $this->BusModel = $BusModel;
    }
    public function index(Request $request)
    {
        Session::put('page', 'timetable');

        $weekDays = $request->input('week_days');
        $today = strtolower(now()->format('l'));

        if (!empty($weekDays)) {
            $timetables = TimeTableStop::where('week_days', $weekDays)->with('getRoute', 'getBusStop')->get()->groupBy(['route_id', 'bus_id']);
        } else {
            $timetables = TimeTableStop::where('week_days', $today)->with('getRoute', 'getBusStop')->get()->groupBy(['route_id', 'bus_id']);
        }

        return view('admin.pages.timetable.list', compact('timetables'));
    }

    public function addStoreTimetable(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }

            DB::beginTransaction();
            try {
                foreach ($request->bus_stop_id as $key => $value) {
                    TimeTableStop::create([
                        'route_id' => $request->route_id,
                        'bus_id' => $request->bus_id,
                        'week_days' => $request->week_days,
                        'bus_stop_id' => $value,
                        'bus_time' => $request->time_with_stop[$key]
                    ]);
                }
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Timetable added Successfully!',
                        'redirect'  => route('admin.timetable.list')
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
        Session::put('page', 'timetable');
        return view('admin.pages.timetable.add');
    }

    public function editUpdateTimetable(Request $request, $timeTableId)
    {
        if ($request->isMethod('post')) {
            $editRules = [
                'bus_time' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $editRules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $updateTimeTable = TimeTableStop::where('id', $timeTableId)->update([
                    'bus_time' => $request->bus_time
                ]);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Timetable updated Successfully!',
                        'redirect'  => route('admin.timetable.list')
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
        Session::put('page', 'timetable');
        $timetableId = Crypt::decrypt($request->id);
        $timetable = TimeTableStop::where('id', $timetableId)->first();
        return view('admin.pages.timetable.edit', compact('timetable'));
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
