<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\CareerExpertInterview;
use App\Models\JobInformation;
use App\Models\Sector;
use Illuminate\Http\Request;

class JobCareerInformationController extends Controller
{
    public function jobInformation(Request $request) {
        $sectors = Sector::where('sector_id', null)->get();
        return view('trainee.career-guidance.job-career-information.job-information')->with(['sectors' => $sectors]);
    }

    public function careerExpertInterview(Request $request) {
        $query = CareerExpertInterview::query();

        if ($request->has('title') && $request->query('title') != '') {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }
        $careerExpertInterviews = $query->paginate(10);
        return view('trainee.career-guidance.job-career-information.career-information')->with(['careerExpertInterviews' => $careerExpertInterviews]);
    }

    public function jobDetails($slug) {
        $job = JobInformation::where('slug', 'ILIKE', '%'.$slug.'%')->first();
        if ($job) {
            return view('trainee.career-guidance.job-career-information.job-detail')->with(['job' => $job]);
        }else {
            return back()->withErrors('Can not find this job!');
        }
    }
}
