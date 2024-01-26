<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Admin\Package\PackageContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class PackageController extends BaseController
{
    private $PackageContract;
    private $PlanModel;

    public function __construct(PackageContract $PackageContract, Plan $PlanModel)
    {
        $this->PackageContract = $PackageContract;
        $this->PlanModel = $PlanModel;
    }
    public function index()
    {
        Session::put('page', 'passcode');
        $plans = Plan::get();
        return view('admin.pages.package.list', compact('plans'));
    }
    public function addPlanFormView()
    {
        Session::put('page', 'passcode');
        return view('admin.pages.package.add');
    }
    public function addPlan(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'title' => 'required',
            'description' => 'required',
            'daily_ride' => 'required',
            'price' => 'required',
            'total_ride' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 400, $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $isAddPlan = Plan::create([
                'title' => $request->title,
                'description' => $request->description,
                'daily_ride' => $request->daily_ride,
                'duration' => $request->duration,
                'price' => $request->price,
                'total_ride' => $request->total_ride,
            ]);
            if ($isAddPlan) {
                DB::commit();
                return $this->responseJson(true, 200, 'Passcode Added Successfully', '', route('admin.passcode.list'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong");
        }
    }

    public function editPlanFormView(Request $request, $id)
    {
        Session::put('page', 'passcode');
        $packageId = Crypt::decrypt($request->id);
        // return $packageId;
        $plans = Plan::find($packageId);
        // dd($plans);
        return view('admin.pages.package.edit', compact('packageId', 'plans'));
    }

    public function updatePlan(Request $request)
    {
        if ($request->isMethod('post')) {
            $index = $request->all();
            $validator = Validator::make($index, [
                'title' => 'required',
                'description' => 'required',
                'daily_ride' => 'required',
                'duration' => 'required',
                'price' => 'required',
                'total_ride' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => false, 'message' => 'field missing'];
            }

            try {
                $updatePlan = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'daily_ride' => $request->daily_ride,
                    'duration' => $request->duration,
                    'price' => $request->price,
                    'total_ride' => $request->total_ride,
                ];
                $updatePlans = Plan::where('id', $request->plan_id)->update($updatePlan);

                if ($updatePlans) {
                    return $this->responseJson(true, 200, 'Passcode Updated Successfully', '', route('admin.passcode.list'));
                } else {
                    return $this->responseJson(false, 200, 'Unable to update record', '', '');
                }
            } catch (\Throwable $th) {

                return ['status' => false, 'message' => $th->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => 'No data post'];
        }
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
                $isDeleted = Plan::where('id', $planId)->update([
                    'deleted_at' => Carbon::now()
                ]);
                if (isset($isDeleted) && !empty($isDeleted)) {
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => 'Deleted Successfully!',
                            'redirect'  => route('admin.passcode.list'),
                            'postStatus' => $request->status
                        ],
                        200
                    );
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, 'Something Went Terribly Wrong.', '', '');
        }
    }
}
