<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends BaseController
{
    public function index()
    {
        Session::put('page', 'settings');
        $privacypolicies = PrivacyPolicy::get();
        return view('admin.pages.privacy_policy.list', compact('privacypolicies'));
    }


    public function addPrivacyPolicyFormShow()
    {
        Session::put('page', 'settings');
        return view('admin.pages.privacy_policy.add_privacy_policy');
    }
    public function storePrivacyPolicy(Request $request)
    {
        if ($request->isMethod('post')) {
            $index = $request->all();
            $validator = Validator::make($index, [
                'title' => 'required',
                'description' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => false, 'message' => 'field missing'];
            }
            DB::beginTransaction();
            try {
                $privacypolicy = [
                    'title' => $request->title,
                    'description' => $request->description,
                ];
                $privacypolicies = PrivacyPolicy::create($privacypolicy);
                DB::commit();
                return $this->responseJson(true, 200, 'Privacy Policy Added Successfully', '', route('admin.privacy.policy.list'));
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
    }

    public function editPrivacyPolicy(Request $request, $id)
    {
        Session::put('page', 'settings');
        $editprivacyPolicies = PrivacyPolicy::find($id);
        return view('admin.pages.privacy_policy.edit_privacy_policy', compact('editprivacyPolicies'));
    }

    public function updatePrivacyPolicy(Request $request)
    {
        if ($request->isMethod('post')) {
            $index = $request->all();
            $validator = Validator::make($index, [
                'title' => 'required',
                'description' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => false, 'message' => 'field missing'];
            }

            try {
                $updatePrivacyPolicy = [
                    'title' => $request->title,
                    'description' => $request->description,
                ];
                $updatePrivacyPolicies = PrivacyPolicy::where('id', $request->privacy_policy__id)->update($updatePrivacyPolicy);

                if ($updatePrivacyPolicies) {
                    return $this->responseJson(true, 200, 'Privacy and Policy updated successfully', '', route('admin.privacy.policy.list'));
                    // return ['status' => true, 'message' => 'Record updated', 'data' =>  url('admin/package/package-list')];
                } else {
                    // return ['status' => false, 'message' => 'Unable to update record'];
                    return $this->responseJson(false, 200, 'Unable to update record', '', '');
                }
            } catch (\Throwable $th) {

                return ['status' => false, 'message' => $th->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => 'No data post'];
        }
    }

    public function destroy($id)
    {
        $deleteprivacyPolicy = PrivacyPolicy::find($id);
        if (empty($deleteprivacyPolicy)) {
            return redirect()->back()->with([
                'error' => 'No record found',
            ]);
        }
        $deleteprivacyPolicy->delete();
        return $this->responseJson(true, 200, 'Privacy Policy deleted successfully', '', route('admin.privacy.policy.list'));
    }
}
