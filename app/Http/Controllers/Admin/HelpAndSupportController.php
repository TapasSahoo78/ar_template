<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HelpAndSupport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HelpAndSupportController extends BaseController
{
    public function index()
    {
        Session::put('page', 'settings');
        $helpAndSupports = HelpAndSupport::get();
        return view('admin.pages.help_and_support.list', compact('helpAndSupports'));
    }

    public function showHelpAndSupportForm(Request $request)
    {
        Session::put('page', 'settings');
        return view('admin.pages.help_and_support.add_help_support');
    }

    public function storeHelpAndSupport(Request $request)
    {
        if ($request->isMethod('post')) {
            $index = $request->all();
            $validator = Validator::make($index, [
                'questions' => 'required',
                'answers' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => false, 'message' => 'field missing'];
            }

            try {
                $helpandsupport = [
                    'questions' => $request->questions,
                    'answers' => $request->answers,
                ];
                $helpandsupports = HelpAndSupport::create($helpandsupport);
                if ($helpandsupports->id > 0) {
                    return $this->responseJson(true, 200, 'Help and Support Added Successfully', '', route('admin.help.support.list'));
                } else {
                    return $this->responseJson(false, 200, 'Unable to save record', '', '');
                }
            } catch (\Throwable $th) {
                return ['status' => false, 'message' => $th->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => 'No record found'];
        }
    }

    public function editHelpAndSupportFormShow(Request $request, $id)
    {
        Session::put('page', 'settings');
        $helpAndSupports = HelpAndSupport::find($id);
        return view('admin.pages.help_and_support.edit_help_and_support', compact('helpAndSupports'));
    }

    public function updateHelpAndSupportForm(Request $request)
    {
        if ($request->isMethod('post')) {
            $index = $request->all();
            $validator = Validator::make($index, [
                'questions' => 'required',
                'answers' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => false, 'message' => 'field missing'];
            }

            try {
                $updatehelpandsupport = [
                    'questions' => $request->questions,
                    'answers' => $request->answers,
                ];
                $updatehelpandsupports = HelpAndSupport::where('id', $request->help_and_support_id)->update($updatehelpandsupport);

                if ($updatehelpandsupports) {
                    return $this->responseJson(true, 200, 'Help and Support updated', '', route('admin.help.support.list'));
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
        $deletehelpandsupport = HelpAndSupport::find($id);
        if (empty($deletehelpandsupport)) {
            return redirect()->back()->with([
                'error' => 'No record found',
            ]);
        }
        $deletehelpandsupport->delete();
        return $this->responseJson(true, 200, 'Help and Support deleted successfully', '', route('admin.help.support.list'));
    }
}
