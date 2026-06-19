<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\CareerExpertInterview;
use App\Models\CareerGuidanceCategory;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\Content;
use App\Models\JobInformation;
use App\Models\Sector;
use App\Models\TraineeUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class CareerTestController extends Controller
{
    public function __construct() {
        $this->middleware('auth:trainee,schoolkid');
    }
    public function index(Request $request) {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $type = $request->has('type') ? $request->type : 'all';
        $test_type = $request->has('test_type') ? $request->test_type : 'all';
        $count = 0;

        $results = CareerTestTraineeResult::query();
        if (Auth::guard('schoolkid')->check()) {
            $results->where('trainee_id', Auth::guard('schoolkid')->user()->id)->where('user_type', 'schoolkid');
        }else {
            $results->where('trainee_id', Auth::guard('trainee')->user()->id);
        }

        if ($type != 'all') {
            $results->where('test_type', $type);
        }
        if ($test_type != 'all') {
            $results->where('career_test_id', $test_type);
        }
        if ($keyword != '') {
            $results->whereHas('careerTest', function ($q) {
                $q->where('test_name', "ILIKE", '%'.$q.'%');
            })->get();
        }
        $count = $results->count();
        $results = $results->orderBy('created_at', 'desc')->paginate(10);
        foreach ($results as $result) {
            if ($result->trainee_id != '') {
                $result->trainee_name = $result->trainee->fullName ?? $result->schoolkid->fullName;
//                $result->institute = $result->trainee->institute->name;
                $result->institute = 'NAITA';
            }else {
                $result->trainee_name = $result->name;
            }
        }
        $careerTests = CareerTest::get();
        return view('trainee.career-guidance.career-test.list', compact('results', 'count', 'careerTests', 'type', 'test_type', 'keyword'));
    }

    public function postUploadExistingTestResult(Request $request) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'type' => 'required',
            'attachment' => ($request->action == 'add') ? ['required', File::types(['doc', 'docx', 'pdf'])->max('2gb')] : '',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $old_attachment = '';
        if ($request->action == 'add') {
            $result = new CareerTestTraineeResult();
//            if (CareerTestTraineeResult::where('trainee_id', Auth::guard('trainee')->user()->id)
//                ->where('test_type', $request->type)
//                ->exists()) {
//                return redirect()->route('trainee.career-guidance.career-test.list')->withErrors("You have update this test before");
//            }
        }elseif ($request->action == 'edit') {
            $result = CareerTestTraineeResult::where('id', $request->id)->first();
            $old_attachment = $result->attachment;
            if (!$result) {
                return redirect()->route('trainee.career-guidance.career-test.list')->withErrors(trans('system.information.content_management.not_found'));
            }
        }
        $result->name = Auth::guard('trainee')->user()->fullName ?? Auth::guard('schoolkid')->user()->fullName;
        $result->trainee_id = Auth::guard('trainee')->user()->id ?? Auth::guard('schoolkid')->user()->id;
        $result->career_test_id = $request->type;
        $result->test_type = $request->type;
        if ($request->has('attachment')) {
            $file = $request->file('attachment');
            $fullName = date("YmdHis").'-'.$file->getClientOriginalName();
            $storage_path = storage_path('app/public/'.activeGuard().'/career-guidance/career-test/'.Auth::guard(activeGuard())->user()->id.'/');
            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }
            $file->move($storage_path, $fullName);
            $path = 'storage/'.activeGuard().'/career-guidance/career-test/'.Auth::guard(activeGuard())->user()->id.'/'.$fullName;
            $result->attachment = $path;
        }
        if (Auth::guard('schoolkid')->check()) {
            $result->user_type = 'schoolkid';
        }
        if ($result->save()) {
            if ($old_attachment != '') {
                unlink($old_attachment);
            }
            return redirect()->route('trainee.career-guidance.career-test.list')->with('success', trans('system.information.content_management.saved'));
        }
    }
    public function downloadResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            if (file_exists($result->attachment)) {
                return response()->download($result->attachment);
            }else {
                return redirect()->route('trainee.career-guidance.career-test.list')->withErrors(trans('system.information.content_management.not_found'));
            }
        }
        return redirect()->back()->withErrors(trans('system.information.content_management.not_found'));
    }

    public function getUpload(Request $request) {
        //Check test result trainee uploaded. For type 3 and 4, Trainee can only upload one file.

        if ($request->has('id')){
            $id = $request->id;
            $test_result = CareerTestTraineeResult::where('id', $request->id)->first();
//            $tests = CareerTest::where('test_type', $test_result->test_type)->get();
            $tests = CareerTest::get();
            return view('trainee.career-guidance.career-test.upload', compact('id', 'test_result', 'tests'));
        }else {
            $allowTypes = [1,2,3,4];
//            if (CareerTestTraineeResult::where('trainee_id', Auth::guard('trainee')->user()->id)->where('test_type', 3)->first()) {
//                $allowTypes = array_diff($allowTypes, [3]);
//            }
//            if (CareerTestTraineeResult::where('trainee_id', Auth::guard('trainee')->user()->id)->where('test_type', 4)->first()) {
//                $allowTypes = array_diff($allowTypes, [4]);
//            }
            $tests = CareerTest::whereIn('test_type', $allowTypes)->get();
            return view('trainee.career-guidance.career-test.upload', compact('tests'));
        }

    }

    public function deleteResult($id) {
        $result = CareerTestTraineeResult::where('trainee_id', Auth::guard('trainee')->user()->id)->where('id', $id)->first();
        if ($result) {
            if (file_exists($result->attachment)) {
                unlink($result->attachment);
            }
            $result->delete();
            return redirect()->route('trainee.career-guidance.career-test.list')->with('success', trans('system.information.content_management.deleted'));
        }else {
            return redirect()->route('trainee.career-guidance.career-test.list')->withErrors(trans('system.information.content_management.not_found'));
        }
    }


    public function viewResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            switch ($result->test_type) {
                case 1:
                    return view('homepage.career-test.results.career-interest-test-result', compact('result'));
                case 2:
                    return view('homepage.career-test.results.career-key-test-result', compact('result'));
                case 3:
                    break;
                case 4:
                    break;
            }

        }
        return \Redirect::back()->withErrors(['msg' => 'Sorry, We can not find this result in system!']);
    }

//    public function attempt(Request $request) {
//        if ($request->has('id')) {
//            return view('homepage.career-test.attempt');
//        }
//    }

    public function getJobInformation(Request $request) {
        $sectors = Sector::query();
        $sectors->where('sector_id', null);
//        $sectors = Sector::where('sector_id', null)->get();
        $keyword = $request->has('keyword') ? $request->keyword : '';
        if ($keyword) {
            $sectors->whereHas('jobs', function ($q) use ($keyword) {
                $q->where('title', "ILIKE", "%".$keyword."%");
            });
        }
        $count = $sectors->count();
        $sectors = $sectors->get();
        return view('trainee.career-guidance.job-career-information.job-information', compact('sectors', 'count', 'keyword'));
    }
    public function getJobInformationDetails($slug) {
        $job = JobInformation::where('slug', 'ILIKE', '%'.$slug.'%')->first();
        if ($job) {
            return view('trainee.career-guidance.job-career-information.job-details', compact('job'));
        }else {
            return back()->withErrors('Can not find this job!');
        }
    }
    public function getCareerExpertInterview(Request $request) {

        $query = CareerExpertInterview::query();
        if ($request->has('search') && $request->query('search')) {
            $query->where('title', 'ILIKE', '%' . $request->query('search') . '%');
        }
        $query->orderBy('created_at', 'desc');
        $careerExpertInterviews = $query->paginate(8);
        $careerExpertInterviews->appends($request->all());
        return view('trainee.career-guidance.job-career-information.career-expert-interview')->with(['careerExpertInterviews' => $careerExpertInterviews]);
    }

    /**
     * Get Career Guide
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
//    public function getCareerGuide(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
//    {
//        $careerGuideCategories = CareerGuidanceCategory::all();
//        $tabId = $request->query('tab', 1);
//        $category = CareerGuidanceCategory::where('id', $tabId)->first();
//        $result = $category->careerGuidances()->paginate(10);
//        return view('career-guidance.career-guide.career-guide')->with(['tabs' => $careerGuideCategories, 'tabId' => $tabId, 'results' => $result]);
//    }

}
