<?php

namespace App\Http\Controllers\Trainee;

use App\Enums\JobStatusEnum;
use App\Enums\Trainee\ApplyTypeEnums;
use App\Enums\TypeTraineeApply;
use App\Enums\WorkingDayEnum;
use App\Http\Controllers\Controller;
use App\Models\CategorySystem;
use App\Models\Company;
use App\Models\CompanyBookmark;
use App\Models\District;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Job;
use App\Models\OjtTraineeApply;
use App\Models\Sector;
use App\Models\OJT;
use App\Models\OjtBookmark;
use App\Models\TraineeApply;
use App\Models\TraineeMatch;
use App\Services\Company\JobVacancyService;
use App\Services\Trainee\JobBookmarkService;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeAppliesService;
use App\Services\Trainee\TraineeJobService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Company\NotificationManager;

class JobSupportController extends Controller
{
    protected TraineeJobService $traineeJobService;
    protected JobVacancyService $jobVacancyService;
    protected jobBookmarkService $jobBookmarkService;
    protected TraineeAppliesService $traineeAppliesService;
    protected ProvincesDistrictsService $provincesDistrictsService;
    protected $notificationManager;

    public function __construct(TraineeJobService $traineeJobService, JobVacancyService $jobVacancyService, JobBookmarkService $jobBookmarkService, TraineeAppliesService $traineeAppliesService, ProvincesDistrictsService $provincesDistrictsService, NotificationManager $notificationManager)
    {
        $this->middleware('trainee.auth');
        $this->traineeJobService = $traineeJobService;
        $this->jobVacancyService = $jobVacancyService;
        $this->jobBookmarkService = $jobBookmarkService;
        $this->traineeAppliesService = $traineeAppliesService;
        $this->provincesDistrictsService = $provincesDistrictsService;
        $this->notificationManager = $notificationManager;
    }


    /**
     * Show job list for trainee
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function showJobList(Request $request): View|RedirectResponse
    {
        $jobs = $this->traineeJobService->getJobList($request);
        $provinces = $this->provincesDistrictsService->getProvinces();


        $sectors = Sector::get();
        // For insert filter
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->provincesDistrictsService->getProvinceAndDistrictById($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'));
        [$sectorsFilter, $subsectorFilter] = $this->traineeJobService->getSectorAndSubSectorById($request->query('sector'), $request->query('subsector'));
        return view('trainee.job-support.job-list', compact( 'jobs', 'provinces', 'sectors', 'provinceFilter', 'districtsFilter', 'divisionalFilter', 'sectorsFilter', 'subsectorFilter'));
    }

    /**
     * Toggle Job Bookmark
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleJobBookmark(Request $request): JsonResponse
    {
        $status = $this->jobBookmarkService->mark($request);

        if ($status == 'unmark') {
            return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have unmarked this job!', 'action' => 'unmark']);
        } else if ($status == 'mark') {
            return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have marked this job!', 'action' => 'mark']);
        } else {
            return response()->json(['status' => 'error', 'code' => 200, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Show job detail
     *
     * @param $job_id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function showJobDetail(Request $request, $job_id): View|RedirectResponse
    {
        $job = $this->jobVacancyService->getJobVacancyById($job_id);

        $traineeApply = $this->traineeAppliesService->getTraineeApplyByJobId($job_id);

        if (!empty($traineeApply)) {
            if (!empty($traineeApply->employeed)) {
                $job->statusApply = 'Employeed';
            } else if (!empty($traineeApply->selected)) {
                $job->statusApply = 'Selected';
            } else {
                $job->statusApply = 'Applied';
            }
        } else {
            $job->statusApply = false;
        }
        if ($job == null) {
            return redirect()->back();
        }
        $working_day = WorkingDayEnum::getAllDay();
        return view('trainee.job-support.job-detail')->with(['job' => $job, 'traineeApply' => $traineeApply,'working_day' => $working_day]);
    }

    public function toggleApply(Request $request): JsonResponse|RedirectResponse
    {
        $status = $this->traineeAppliesService->toggleApply($request);
        if ($request->has('redirect')) {
            if ($status == 'cancel') {
                return redirect()->back()->with('error', "Job closed, cannot apply!");
            }
            return redirect()->back()->with('success', 'You have applied this job!');
        }
        if ($status == 'apply') {
            return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have applied this job!', 'action' => 'apply']);
        } else if ($status == 'unapply') {
            return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have not applied this job!', 'action' => 'unapply']);
        } else if ($status == 'cancel') {
            return response()->json(['status' => 'error', 'code' => 200, 'message' => "Job closed, can't apply!", 'action' => 'cancel']);
        } else {
            return response()->json(['status' => 'error', 'code' => 200, 'message' => 'Something went wrong!']);
        }
    }


    public function companyList(Request $request)
    {
        $trainee_id = Auth::guard(activeGuard())->user()->id;
        $language = app()->getLocale();
        $sectors = Sector::get();
        $provinces = $this->provincesDistrictsService->getProvinces();
        $companyInformations = getCodeList('company_information', $language);
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->provincesDistrictsService
            ->getProvinceAndDistrictById(
                $request->query('province'),
                $request->query('district'),
                $request->query('divisional_secretariat')
            );

        [$sectorsFilter, $subsectorFilter] = $this->traineeJobService
            ->getSectorAndSubSectorById(
                $request->query('sector'),
                $request->query('subsector')
            );

        $query = Company::query()
            ->whereNotNull('verified_at')
            ->whereNotNull('verified_by')
            ->where('active', true)
            ->orderBy('name', 'asc');
        if ($request->filled('title')) {
            $query->where('name', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->filled('sector')) {
            $sectorId = $request->query('sector');
            $query->whereHas('jobs', function ($q) use ($sectorId) {
                $q->where('sector_id', $sectorId);
            });
        }

        if ($request->filled('province')) {
            $query->whereHas('district', function ($q) use ($request) {
                $q->where('prov_id', $request->query('province'));

                if ($request->filled('district')) {
                    $q->where('id', $request->query('district'));
                }
            });
        }

        if ($request->filled('divisional_secretariat') && $request->query('divisional_secretariat') != 'all') {
            $query->where('ds_id', $request->query('divisional_secretariat'));
        }

        if ($request->filled('company_information') && $request->query('company_information') != 'all') {
            $query->where('company_information', $request->query('company_information'));
        }

        if ($request->filled('bookmark') && $request->query('bookmark') != 'all') {
            $bookmarkStatus = $request->query('bookmark');

            if ($bookmarkStatus == 'mark') {
                $query->whereHas('bookmarks', function ($q) use ($trainee_id) {
                    $q->where('trainee_id', $trainee_id);
                });
            } else {
                $query->whereDoesntHave('bookmarks', function ($q) use ($trainee_id) {
                    $q->where('trainee_id', $trainee_id);
                });
            }
        }
        $companies = $query->paginate(10);
        return view('trainee.job-support.company.company-list', [
            'companies' => $companies,
            'sectors' => $sectors,
            'provinceFilter' => $provinceFilter,
            'districtsFilter' => $districtsFilter,
            'divisionalFilter' => $divisionalFilter,
            'sectorsFilter' => $sectorsFilter,
            'subsectorFilter' => $subsectorFilter,
            'provinces' => $provinces,
            'companyInformations' => $companyInformations
        ]);
    }


    public function companyDetail($id, $slug)
    {
        $company = Company::where('slug', $slug)->where('id', $id)->first();
        if (!$company) {
            return redirect()->route('trainee.job-support.company.company-list')->with('error', 'Fail to get company!');
        }
        $events = $company->events()->orderBy('end_time', 'asc')->take(3)->get();

        $jobs = $company->jobs()
        ->where('status', JobStatusEnum::PROGRESS->value)
//        ->where(function ($query) {
//            $query->where(function($query) {
//                $query->whereNull('application_starttime')
//                    ->orWhere('application_starttime', '<=', now());
//            })
//            ->where(function($query) {
//                $query->whereNull('application_endtime')
//                    ->orWhere('application_endtime', '>=',now());
//            });
//        })
        ->orderBy('application_endtime', 'asc')
        ->limit(4)
        ->get();


        return view('trainee.job-support.company.company-detail')->with(['company' => $company, 'events' => $events, 'jobs' => $jobs]);
    }

    public function companyEvent(Request $request, $id, $slug)
    {
        $company = Company::where('slug', $slug)->where('id', $id)->firstOrFail();

        $query = $company->events()->newQuery();

        $query->where('status', 2)->orderBy('created_at', 'asc');
        $event_types = CategorySystem::where('module', 'event')->get();

        if ($request->has('title') && $request->query('title') != '') {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->has('event_type') && $request->query('event_type') !== 'all') {
            $query->where('event_type', $request->query('event_type'));
        }

        if ($request->has('sort_by') && $request->query('sort_by') !== '') {
            if ($request->query('sort_by') === 'oldest')
                $query->orderBy('created_at', 'desc');
        }

        $events = $query->paginate(10);
        return view('trainee.job-support.company.event-list')->with(['event_types' => $event_types, 'company' => $company, 'events' => $events]);
    }

    public function companyJob(Request $request, $id, $slug)
    {
        $company = Company::where('slug', $slug)->where('id', $id)->first();
        if (!$company) {
            return redirect()->route('trainee.job-support.company.company-list')
                ->with('error', 'Fail to get company!');
        }


//        $query = $company->jobs()->where('status', JobStatusEnum::PROGRESS->value)
//            ->orderBy('application_endtime', 'desc')
//            ->where(function ($query) {
//                $query->where(function ($query) {
//                    $query->whereNull('application_starttime')
//                        ->whereNull('application_endtime');
//                })
//                    ->orWhere(function ($query) {
//                        $query->where('application_starttime', '<=', now())
//                            ->where('application_endtime', '>=', now());
//                    });
//            });
        $query = $company->jobRecruitings();

        if ($request->filled('title')) {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }


        if ($request->filled('job_type') && $request->query('job_type') === 'oldest') {
            $query->orderBy('application_endtime', 'asc');
        }


        $jobs = $query->paginate(10);

        return view('trainee.job-support.company.job-post', [
            'company' => $company,
            'jobs' => $jobs,
        ]);
    }


    public function matchJob(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $data['match_time'] = now();

        $isExist = TraineeMatch::where(['trainee_id' => $data['trainee_id'], 'job_id' => $data['job_id']])->first();

        if ($isExist) {
            try {
                $isExist->delete();
                $traineeApply = TraineeApply::where('trainee_id', $data['trainee_id'])->where('job_id', $data['job_id'])->first();
                if ($traineeApply) {
                    $traineeApply->delete();
                }
                if ($request->redirect) {
                    return redirect()->back()->with('success', 'You have unmatched this job');
                }
                return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have unmatched this job', 'action' => 'unmatch']);
            } catch (ModelNotFoundException $e) {
                return response()->json(['status' => 'fail', 'code' => 201, 'message' => 'Record not found '.$e, 'action' => 'null']);
            }
        }
        $traineeMatch = TraineeMatch::create($data);
        $traineeApplyData = new TraineeApply();
        $traineeApplyData->job_id = $data['job_id'];
        $traineeApplyData->trainee_id = $data['trainee_id'];
        $traineeApplyData->apply_time = now();
        $traineeApplyData->read = null;
        $traineeApplyData->selected = null;
        $traineeApplyData->employeed = null;
        $traineeApplyData->selected_by = null;
        $traineeApplyData->apply_type = 'job_match';
        $traineeApplyData->save();
        if ($request->redirect) {
            return redirect()->back()->with('success', 'You have matched this job');
        }
        return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have matched this job!', 'action' => 'match']);
    }

    public function jobDetail($id, $slug)
    {
        $sectors = Sector::all();
        $districts = District::all();
        $job = Job::where('slug', $slug)->where('id', $id)->firstOrFail();
        $traineeApply = $this->traineeAppliesService->getTraineeApplyByJobId($job->id);
        $job->creator_first_name = $job->companyRecruiter->first_name;
        $job->creator_last_name = $job->companyRecruiter->last_name;
//        if (!is_array($job->gender)) {
//            $job->gender = [$job->gender]; // Wrap it in an array
//        }
//        $job->working_day = $job->working_day ? explode(',', $job->working_day) : [];
        $job->start_date = $job->start_date ? Carbon::parse($job->start_date)->format('Y-m-d') : '';
        $job->application_starttime = $job->application_starttime ? Carbon::parse($job->application_starttime)->format('Y-m-d') : null;
        $job->application_endtime = $job->application_endtime ? Carbon::parse($job->application_endtime)->format('Y-m-d') : null;
//        $job->required_skills = $job->required_skills ? explode(',', $job->required_skills) : [];
        $job->company_name = $job->company->name;
        $job->sector_name = $job->sector->name;
        $attachmentsPath = storage_path('app/public/company/job_vacancy_attachments/' . $job->id);
        $attachments = [];

        if (file_exists($attachmentsPath) && is_dir($attachmentsPath)) {
            $files = glob($attachmentsPath . '/*');
            foreach ($files as $file) {
                $attachments[] = basename($file);
            }
        }
        $job->attachments = $attachments;

        if (!empty($traineeApply)) {
            if (!empty($traineeApply->employeed)) {
                $job->statusApply = 'Employeed';
            } else if (!empty($traineeApply->selected)) {
                $job->statusApply = 'Selected';
            } else {
                $job->statusApply = 'Applied';
            }
        } else {
            $job->statusApply = false;
        }
        if ($job == null) {
            return redirect()->back();
        }
        $working_day = WorkingDayEnum::getAllDay();
        return view('trainee.job-support.company.job-details')->with(['jobDetail' => $job, 'sectors' => $sectors, 'districts' => $districts, 'traineeApply' => $traineeApply, 'working_day' => $working_day]);
    }

    public function eventDetail($company, $id, $slug)
    {
        $company = Company::where('id', $company)->first();
        $event = Event::where('slug', $slug)->where('id', $id)->firstOrFail();

        return view('trainee.job-support.company.event-detail')->with(['event' => $event, 'company' => $company]);
    }

    public function toggleBookmarkCompany(Request $request)
    {
        $data = $request->all();
        try {
            $marked = CompanyBookmark::where('trainee_id', Auth::guard('trainee')->user()->id)->where('company_id', $data['company_id'])->first();

            if (isset($data['redirect'])) {
                if ($marked) {
                    $marked->delete();
                    return redirect()->back();
                }

                CompanyBookmark::create($data);
                return redirect()->back();
            } else {
                if ($marked) {
                    try {
                        $marked->delete();
                        return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have unmarked this company!', 'action' => 'unmark']);
                    } catch (ModelNotFoundException $e) {
                        return response()->json(['status' => 'fail', 'code' => 201, 'message' => $e, 'action' => 'null']);
                    }
                }
                CompanyBookmark::create($data);
                return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have marked this company!', 'action' => 'mark']);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'fail', 'code' => 201, 'message' => $exception, 'action' => 'null']);
        }
    }

    public function ojtListCustom(Request $request)
    {
        $ojts = $this->traineeJobService->getOJTList($request);
        $provinces = $this->provincesDistrictsService->getProvinces();
        $sectors = Sector::get();
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->provincesDistrictsService->getProvinceAndDistrictById($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'));
        [$sectorsFilter, $subsectorFilter] = $this->traineeJobService->getSectorAndSubSectorById($request->query('sector'), $request->query('subsector'));
        return view('trainee.job-support.ojt.ojt-list-custom', compact( 'ojts', 'provinces', 'sectors', 'provinceFilter', 'districtsFilter', 'divisionalFilter', 'sectorsFilter', 'subsectorFilter'));
    }
        public function getTraineeApplyByOJTId($id)
    {
        $trainee_id = auth()->guard('trainee')->user()->id;
        return OjtTraineeApply::where('trainee_id', $trainee_id)->where('ojt_id', $id)->where('apply_type', TypeTraineeApply::APPLY->value)->first();

    }
    public function ojtDetail($id, $slug)
    {
        $ojt = OJT::where('slug', $slug)->where('id', $id)->firstOrFail();

        $trainee_id='';
        $hasApplied='';
        $hasApproved='';
        $traineeApply = $this->getTraineeApplyByOJTId($ojt->id);

        if (!empty($traineeApply)) {
            if (!empty($traineeApply->employeed)) {
                $ojt->statusApply = 'Employeed';
            } else if (!empty($traineeApply->selected)) {
                $ojt->statusApply = 'Selected';
            } else {
                $ojt->statusApply = 'Applied';
            }
        } else {
            $ojt->statusApply = false;
        }
        if(!empty(Auth::guard('trainee')->user())){
             $trainee= Auth::guard('trainee')->user();
             $hasApplied = OjtTraineeApply::where('ojt_id', $ojt->id)->where('trainee_id', $trainee->id)->where('apply_type', 'apply')->first();
             $hasApproved = OjtTraineeApply::where('ojt_id', $ojt->id)->where('trainee_id', $trainee->id)->whereNotNull('employeed')->first();
            }
        $totalAppliedAndMatched = OjtTraineeApply::where('ojt_id', $ojt->id)
            ->whereIn('apply_type', ['apply', 'ojt_match'])
            ->distinct('trainee_id')
            ->count('trainee_id');
        $hasEnough = ((int)$ojt->number_of_recruitments <= (int)$totalAppliedAndMatched);
        return view('trainee.job-support.ojt.ojt-detail')->with(['hasEnough' => $hasEnough, 'ojt' => $ojt,'trainee'=>$trainee, 'hasApproved'=>$hasApproved, 'hasApplied'=>$hasApplied,'companyList' => Company::whereNotNull('verified_at')->whereNotNull('verified_by')->get()]);
    }

    public function toggleOjtBookmark(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            $marked = OjtBookmark::where('trainee_id', $data['trainee_id'])->where('ojt_id', $data['ojt_id'])->first();

            if (isset($data['redirect'])) {
                if ($marked) {
                    $marked->delete();
                    return redirect()->back();
                }

                OjtBookmark::create($data);
                return redirect()->back();
            } else {
                if ($marked) {
                    try {
                        $marked->delete();
                        return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have unmarked this OJT!', 'action' => 'unmark']);
                    } catch (Exception $e) {
                        return response()->json(['status' => 'fail', 'code' => 201, 'message' => $e, 'action' => 'null']);
                    }
                }
                OjtBookmark::create($data);
                return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have marked this OJT!', 'action' => 'mark']);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'fail', 'code' => 201, 'message' => $exception, 'action' => 'mark']);
        }
    }

    public function ojtApply(Request $request)
    {
        $data = $request->all();
        $ojt = OJT::where('id', $data['ojt_id'])->first();

        if (!$ojt) {
            return response()->json([
                'message' => 'OJT not found!',
                'status' => 'error',
            ], 404);
        }

        if ($ojt->status !== 1) {
            return response()->json([
                'message' => 'OJT closed, cannot apply!',
                'status' => 'error',
            ], 422);
        }
        $already = OjtTraineeApply::where('ojt_id', $data['ojt_id'])
            ->where('trainee_id', $data['trainee_id'])
            ->where('apply_type', 'apply')
            ->first();

        if ($already) {
            return response()->json([
                'message' => 'You have already applied!',
                'status' => 'error',
            ], 409);
        }

        $data['apply_time'] = now();
        $data['apply_type'] = 'apply';

        $apply=OjtTraineeApply::create($data);
        $trainee_name= $apply->user->full_name;
        $company=$ojt->owner;
        $this->notificationManager->sendNotificationApplyOJT( $company,$ojt,$trainee_name);
        return response()->json([
            'message' => 'You have applied OJT successfully!',
            'status' => 'success',
            'id' => $apply->id,
        ]);
    }

    public function OJTunApply(Request $request)
    {
        $id = $request->input('id');
        $apply = OjtTraineeApply::find($id);

        if (!$apply) {
            return response()->json([
                'message' => 'Application not found!',
                'status' => 'error',
            ], 404);
        }
        $apply->delete();

        return response()->json([
            'message' => 'You have unapplied successfully!',
            'status' => 'success',
            'ojt_id' => $apply->ojt_id,
            'trainee_id' => $apply->trainee_id,
        ]);
    }

}
