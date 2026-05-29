<?php

namespace App\Http\Controllers\CGO;

use App\Http\Controllers\Controller;
use App\Models\CareerExpertInterview;
use App\Models\CareerGuidanceCategory;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\JobInformation;
use App\Models\Sector;
use App\Models\TraineeInstitute;
use App\Models\TraineeUser;
use Illuminate\Http\Request;

class CareerTestController extends Controller
{
    public function __construct() {
        $this->middleware('cgo.auth');
    }
    public function index(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $type = $request->has('type') ? $request->type : 'all';
        $test_type = $request->has('test_type') ? $request->test_type : 'all';
        $count = 0;
        $instituteCgo = auth('cgo')->user()->institute_id;
        
        $traineeIds = TraineeInstitute::where('institute_id', $instituteCgo)
            ->groupBy('trainee_id')
            ->pluck('trainee_id')
            ->toArray();
    
        $results = CareerTestTraineeResult::where(function($query) use ($traineeIds, $instituteCgo) {
            $query->whereIn('trainee_id', $traineeIds)
                  ->orWhere('institute_id', $instituteCgo);
        });
    
        if ($keyword != '') {
            $results->where(function($query) use ($keyword) {
                $query->where('name', 'ilike', "%{$keyword}%")
                      ->orWhereHas('trainee', function($q) use ($keyword) {
                          $q->where('full_name', 'ilike', "%{$keyword}%");
                      });
            });
        }
    
        if ($type != 'all') {
            $results->where('type', $type);
        }
    
        if ($test_type != 'all') {
            $results->where('career_test_id', $test_type);
        }
    
        $count = $results->count();
        $results = $results->orderBy('created_at', 'desc')->paginate(10);
    
        foreach ($results as $result) {
            if (!empty($result->trainee_id)) {
                $result->trainee_name = $result->trainee->full_name ?? $result->name;
                $currentYear = date("Y", strtotime($result->created_at));
            } else {
                $result->trainee_name = $result->name;
            }
        }
    
        $careerTests = CareerTest::get();
        
        return view('cgo.career-guidance.career-test.list', compact(
            'results', 
            'count', 
            'careerTests', 
            'type', 
            'test_type', 
            'keyword'
        ));
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

    public function downloadResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            return response()->download($result->attachment);
        }
        return redirect()->back()->withErrors(trans('system.information.content_management.not_found'));
    }

//    public function getJobInformation(Request $request) {
//        $sectors = Sector::query();
//        $sectors->where('sector_id', null);
////        $sectors = Sector::where('sector_id', null)->get();
//        $keyword = $request->has('keyword') ? $request->keyword : '';
//        if ($keyword) {
//            $sectors->whereHas('jobs', function ($q) use ($keyword) {
//                $q->where('title', "ILIKE", "%".$keyword."%");
//            });
//        }
//        $count = $sectors->count();
//        $sectors = $sectors->get();
//        return view('cgo.career-guidance.job-career-information.job-information', compact('sectors', 'count', 'keyword'));
//    }
//    public function getJobInformationDetails($slug) {
//        $job = JobInformation::where('slug', 'ILIKE', '%'.$slug.'%')->first();
//        if ($job) {
//            return view('cgo.career-guidance.job-career-information.job-details', compact('job'));
//        }else {
//            return back()->withErrors('Can not find this job!');
//        }
//    }
//    public function getCareerExpertInterview(Request $request) {
//
//        $query = CareerExpertInterview::query();
//        if ($request->has('search') && $request->query('search')) {
//            $query->where('title', 'ILIKE', '%' . $request->query('search') . '%');
//        }
//        $query->orderBy('created_at', 'desc');
//        $careerExpertInterviews = $query->paginate(8);
//        $careerExpertInterviews->appends($request->all());
//        return view('cgo.career-guidance.job-career-information.career-expert-interview')->with(['careerExpertInterviews' => $careerExpertInterviews]);
//    }
//    public function getCareerGuide(Request $request) {
//        $careerGuideCategories = CareerGuidanceCategory::all();
//        $tabId = $request->query('tab', 1);
//        $category = CareerGuidanceCategory::where('id', $tabId)->first();
//        $result = $category->careerGuidances()->paginate(10);
//        // $result = $careerGuidances::paginate(10);
//        return view('cgo.career-guidance.career-guide.career-guide')->with(['tabs' => $careerGuideCategories, 'tabId' => $tabId, 'results' => $result]);
//    }

}
