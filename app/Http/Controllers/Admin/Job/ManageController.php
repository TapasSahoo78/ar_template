<?php

namespace App\Http\Controllers\Admin\Job;

use App\Contracts\Admin\Job\JobContract;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManageController extends Controller
{
    private $JobContract;
    private $JobModel;

    protected  $rules = [
        'title' => 'required|string',
        'experience' => 'required|numeric',
        'salary' => 'required|numeric',
        'location' => 'required|string',
        'description' => 'required|string',
    ];

    public function __construct(JobContract $JobContract, Job $JobModel)
    {
        $this->JobContract = $JobContract;
        $this->JobModel = $JobModel;
    }
    public function index()
    {
        Session::put('page', 'job');
        $jobs = $this->JobContract->allJobs();
        return view('admin.pages.job.list', compact('jobs'));
    }

    public function addStoreJob(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $insert_arry = request()->except(['_token', '_method', 'id']);
                $addRoute = $this->JobContract->storeJob($insert_arry);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Job added Successfully!',
                        'redirect'  => route('admin.job.list')
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
        Session::put('page', 'job');
        return view('admin.pages.job.add');
    }

    public function editUpdateJob(Request $request, $jobId)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $update_arry = request()->except(['_token', '_method', 'id']);

                $updateRoute = $this->JobContract->updateJob($update_arry, $jobId);
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Job updated Successfully!',
                        'redirect'  => route('admin.job.list')
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
        Session::put('page', 'job');
        $jobId = Crypt::decrypt($request->id);
        $job = $this->JobContract->findJob($jobId);
        return view('admin.pages.job.edit', compact('job'));
    }

    public function deleteJob(Request $request, $id)
    {
        $packageId = Crypt::decrypt($request->id);
        try {
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => 'something went wrong'];
        }
    }
}
