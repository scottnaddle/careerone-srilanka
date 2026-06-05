<?php

namespace App\Http\Controllers;

use App\Enums\JobStatusEnum;
use App\Enums\StatusEnumsManagement;
use App\Enums\TypeTraineeApply;
use App\Enums\WorkingDayEnum;
use App\Models\Banner;
use App\Models\CareerGuidanceCategory;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\ContentViewLog;
use App\Models\Event;
use App\Models\Institute;
use App\Models\Popup;
use App\Models\ReactiveAccountRequest;
use App\Models\Sector;
use App\Models\TraineeInstitute;
use App\Services\Company\JobVacancyService;
use App\Services\ContentViewLoggerService;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeInformationService;
use App\Services\Trainee\TraineeJobService;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\TraineeUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class HomepageController extends Controller
{
    public function __construct(TraineeTrainingSyncService $traineeTrainingSyncService, JobVacancyService $jobVacancyService, ProvincesDistrictsService $provincesDistrictsService, TraineeJobService $traineeJobService, TraineeInformationService $traineeInfomationService)
    {
        $this->jobVacancyService = $jobVacancyService;
        $this->provincesDistrictsService = $provincesDistrictsService;
        $this->traineeJobService = $traineeJobService;
        $this->traineeInfomationService = $traineeInfomationService;
        $this->traineeTrainingSyncService = $traineeTrainingSyncService;
    }
    public function index()
    {
        $banners = Banner::where('is_visible', true)->with(['bannerImage'])->orderBy('sort', 'asc')->get();
        $currentDate = now();
//        $events = Event::where('status', StatusEnumsManagement::APPROVED->value)
//            ->when(Event::where('status', StatusEnumsManagement::APPROVED->value)->where('sort', '!=', 0)->doesntExist(), function ($query) {
//                // Nếu tất cả sort đều là 0, lấy 4 bản ghi mới nhất
//                $query->orderBy('id', 'desc')->take(4);
//            }, function ($query) {
//                // Nếu sort đã có giá trị, thực hiện sắp xếp theo CASE
//                $query->orderByRaw("
//                CASE sort
//                    WHEN 1 THEN 1
//                    WHEN 2 THEN 2
//                    WHEN 3 THEN 3
//                    WHEN 4 THEN 4
//                    ELSE 5
//                END ASC
//            ")
//                    ->orderBy('sort', 'asc')
//                    ->take(4);
//            })
//            ->get();
        $mainEvent = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->where('is_main_event',true)
                ->inRandomOrder()->first();
        if (!$mainEvent) {
            $mainEvent = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->latest()->first();
            $newestEvents = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->where(function (Builder $query) {
                    $query->where('is_main_event', false)
                        ->orWhereNull('is_main_event');
                })
                ->where('id', '!=', $mainEvent->id)
                ->latest('created_at')->take(3)
                ->get();
        }else {
            $newestEvents = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->where(function (Builder $query) {
                    $query->where('is_main_event', false)
                        ->orWhereNull('is_main_event');
                })
                ->latest('created_at')->take(3)
                ->get();
        }


//        $events = Event::where('status', StatusEnumsManagement::APPROVED->value)
//            ->where('show_on_homepage', true)
//            ->when(
//                Event::where('status', StatusEnumsManagement::APPROVED->value)
//                    ->where('show_on_homepage', true)
//                    ->where('sort', '!=', 0)
//                    ->doesntExist(),
//                function ($query) {
//                    // Nếu tất cả sort đều là 0
//                    $query->orderBy('id', 'desc')->take(4);
//                },
//                function ($query) {
//                    // Nếu có sort khác 0
//                    $query->orderBy('sort', 'asc')->take(4);
//                }
//            )
//            ->get();

        $jobs = Job::query();

        $jobs->where('status', JobStatusEnum::PROGRESS->value);
        $recent_jobs = $jobs->where('status', JobStatusEnum::PROGRESS->value)
            ->whereHas('company', function ($query) {
                $query->whereNotNull('verified_at');
                $query->whereNotNull('verified_by');
            })
            ->latest()
            ->take(4)
            ->get();

        $contentCategory = CareerGuidanceCategory::first();

        $contentsQuery = $contentCategory->contentApproved()->inRandomOrder();

        $contents = $contentsQuery->take(4)->get();

        $sectors = array(
            ['name' => 'ICT', 'thumbnail' => asset('images/sector/ict_small.webp'), 'thumbnail_mobile' => asset('images/sector/mobile/ict_small.webp'), 'short_description' => 'ICT plays a critical role in today’s digital economy, impacting nearly every sector by providing
solutions for businesses, government, healthcare, finance, education, and beyond.', 'url' => route('sector.ict')],
            ['name' => 'Tourism', 'thumbnail' => asset('images/sector/tourism_small.webp'), 'thumbnail_mobile' => asset('images/sector/mobile/tourism_small.webp'), 'short_description' => 'Sri Lanka, often called the "Pearl of the Indian Ocean," is a captivating destination where
golden beaches meet lush landscapes, and ancient history blends seamlessly with modern
luxury. This diverse island is not only a cultural treasure trove but also a rapidly growing hub
for global tourism and hospitality', 'url' => route('sector.tourism')],
            ['name' => 'Manufacturing', 'thumbnail' => asset('images/sector/manufacturing_small.webp'), 'thumbnail_mobile' => asset('images/sector/mobile/manufacturing_small.webp'), 'short_description' => '', 'url' => route('sector.manufactoring')],
            ['name' => 'Construction', 'thumbnail' => asset('images/sector/construction_small.webp'), 'thumbnail_mobile' => asset('images/sector/mobile/construction_small.webp'), 'short_description' => 'As a developing country with ambitious infrastructure goals, Sri Lanka relies on construction
to support urbanisation, enhance connectivity, and stimulate industrial growth.', 'url' => route('sector.construction')],
        );

        $now = Carbon::now();
        $today = $now->toDateString();

        $popups = Popup::where('status', 'active')
            ->where(function ($q) use ($today) {
                $q->whereNull('start_time')
                    ->orWhereDate('start_time', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_time')
                    ->orWhereDate('end_time', '>=', $today);
            })
            ->get();
        return view('homepage.index', compact('mainEvent', 'newestEvents', 'recent_jobs', 'sectors', 'banners', 'popups', 'contents', 'contentCategory'));
    }

    public function getTests()
    {
        $careerTests = CareerTest::all();
        return view('homepage.career-test.list', compact('careerTests'));
    }

    public function attempt($id)
    {
        $careerTest = CareerTest::where('id', $id)->first();
        //1: Career Interest test,  2: Career Key test , 3:Interest and Ability Test, 4: Interest, Ability and Personality Test
        $view = '';
        switch ($careerTest->test_type) {
            case 1:
                $view = 'career-interest-test';
                break;
            case 2:
                $view = 'career-key-test';
                break;
        }
        $traineeUser = Auth::guard('trainee')->user();
        $userFullName = $traineeUser ? $traineeUser->fullName : '';
        $userNIC = $traineeUser ? $traineeUser->nic : '';
        $institutes = [];
        if ($traineeUser) {
            $this->traineeTrainingSyncService->syncTraineeTrainingInformation($traineeUser); //sync lại 1 lần để lấy những thông tin mới nhất
        }
        if ($traineeUser && TraineeInstitute::where('trainee_id', $traineeUser->id)->count() > 0) {
            $histories = TraineeInstitute::where('trainee_id', $traineeUser->id)->get();
            foreach ($histories as $history) {
                $institutes[] = $history->institute;
            }
            $institutes = array_unique($institutes);
        }else {
            $institutes = Institute::where('active_status', 'ILIKE', 'Active')->get();
        }

        if ($view == '') {
            return back()->with('message', 'We can not find the test');
        }
        return view('homepage.career-test.' . $view, compact('userFullName', 'userNIC', 'institutes'));
    }

    public function postResults(Request $request)
    {
//        $traineeId = (activeGuard() == 'trainee' && Auth::guard('trainee')->check()) ? Auth::guard('trainee')->user()->id : null;
        $traineeName = $request->name;
        $result = new CareerTestTraineeResult();
        $result->name = $traineeName;
        $result->nic = $request->nic ?? "";
        $result->institute_id = $request->institute ?? "";
        $trainee = TraineeUser::where('nic', $request->nic)->first();
        $result->trainee_id = $trainee->id ?? null;
        $result->career_test_id = $request->type;
        $result->test_type = $request->type; //Career Key test
        $result->result = $request->results;
        $result->note = null;
        $msg = 'Success';
        if ($result->save()) {
            return [
                'status' => true,
                'data' =>  $result,
                'message' => $msg
            ];
        } else {
            return \Response::json(['error' => 'Error when save database'], 404);
        }
    }

    public function aboutUs()
    {
        $countCGO = CgoUser::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)->count();
        $countTrainee = TraineeUser::where('active', true)->count();
//        $countInstitute = Institute::count();
        $countInstitute = CgoUser::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)->distinct('institute_id')->count('institute_id');
//        $countCompany = Company::where('active', true)->count();
        $countCompany = CompanyRecruiter::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)->count();
        return view('homepage.about-us', compact('countCGO', 'countTrainee', 'countInstitute', 'countCompany'));
    }
    public function contactUs()
    {
        return view('homepage.contact-us');
    }

    public function companyDetail($id, $slug)
    {
        $company = Company::where('slug', $slug)->where('id', $id)->first();
        if (!$company) {
            return redirect()->route('trainee.job-support.company.company-list')->with('error', 'Fail to get company!');
        }
        $events = $company->events()->orderBy('end_time', 'asc')->take(3)->get();

        $jobs = $company->jobs()->where('status', JobStatusEnum::PROGRESS->value)->orderBy('application_endtime', 'asc')->limit(3)->get();
        //        dd($jobs);
        return view('trainee.job-support.company.company-detail')->with(['company' => $company, 'events' => $events, 'jobs' => $jobs]);
    }

    public function showJobVacancy($job_id, $slug): Application|Factory|View|RedirectResponse
    {
        $working_day = WorkingDayEnum::getAllDay();
        $required_skills = array(
            '1' => 'English',
            '2' => 'Graduated',
            '3' => 'Leadership',
        );

        $job = $this->jobVacancyService->getJobVacancyById($job_id);

        return view('company.job-support.job-vacancy.show', compact('job', 'working_day', 'required_skills', 'slug'));
    }

    public function getJobList(Request $request): mixed
    {
        $jobs = Job::query();

        $jobs->where('status', JobStatusEnum::PROGRESS->value);
//        ->where(function ($query) {
//            $query->where(function ($query) {
//                $query->whereNull('application_starttime')
//                      ->whereNull('application_endtime');
//            })
//            ->orWhere(function ($query) {
//                $query->where('application_starttime', '<=', now())
//                      ->where('application_endtime', '>=', now());
//            });
//        });

        if ($request->has('title') && $request->query('title') != '') {
            $title = $request->query('title');
            $jobs->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($title) . '%'])
                ->orWhereHas('company', function ($query) use ($title) {
                    $query->where('name', 'ILIKE', '%' . $title . '%');
                });
        }

        if ($request->has('province') && $request->query('province') != '') {
            $jobs->whereHas('company.district', function ($query) use ($request) {
                if ($request->has('province')) {
                    $query->where('prov_id', $request->query('province'));
                }
                if ($request->has('district') && $request->query('district') != '') {
                    $query->where('id', $request->query('district'));
                }
            });
        }

        if ($request->has('sector') && $request->query('sector') != '') {
            $jobs->where('jobs.sector_id', $request->query('sector'));
        }

        $jobs->select('jobs.*')
            ->addSelect([
                'companies.name as company_name',
                'companies.logo as company_logo',
                'sectors.name as sector_name',
                'company_recruiters.first_name as creator_first_name',
                'company_recruiters.last_name as creator_last_name',
            ])
            ->join('companies', 'companies.id', '=', 'jobs.company_id')
            ->join('sectors', 'sectors.id', '=', 'jobs.sector_id')
            ->join('company_recruiters', 'company_recruiters.id', '=', 'jobs.created_by');

        $sortBy = $request->query('sort_by') == 'recently' ? 'desc' : 'asc';
        $jobs->orderBy('created_at', $sortBy);

        $jobs = $jobs->paginate(10)->appends($request->query());

        foreach ($jobs as $job) {
            $job->company_logo = file_exists($job->company_logo) ? asset($job->company_logo) : '';
        }

        $provinces = $this->provincesDistrictsService->getProvinces();

        $sectors = Sector::get();
        // For insert filter
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->provincesDistrictsService->getProvinceAndDistrictById($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'));
        [$sectorsFilter, $subsectorFilter] = $this->traineeJobService->getSectorAndSubSectorById($request->query('sector'), $request->query('subsector'));

        return view('trainee.job-support.job-list', compact('jobs', 'provinces', 'sectors', 'provinceFilter', 'districtsFilter', 'divisionalFilter', 'sectorsFilter', 'subsectorFilter'));
    }
    public function tempUpload(Request $request)
    {
        if ($request->hasFile('attached_file')) {
            $file = $request->file('attached_file');
            $path = $file->store('temp/uploads');

            // Lưu đường dẫn vào session
            session(['temp_file' => $path]);

            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function checkNICForCareerTest(Request $request)
    {
        $traineeInformation = $this->traineeInfomationService->getTraineeInformation($request->nic);

        if ($traineeInformation['message'] != 'No Information.') {
            return response()->json([
                'success' => 'NIC confirmed!',
                'data' => $traineeInformation['message']
            ]);
        }
        return response()->json([
            'error' => 'NIC confirm fail!',
            'data' => $traineeInformation['message']
        ]);
    }

    public function getIctSector() {
        return view('sector.ict');
    }
    public function getManufactoringSector() {
        return view('sector.manufactoring');
    }
    public function getTourismSector() {
        return view('sector.tourism');
    }
    public function getConstructionSector() {
        return view('sector.construction');
    }

    public function reactiveAccount(Request $request)
    {
        // Decode the user ID and get the user type
        $userId = base64_decode($request->token);
        $userType = $request->u_type;

        // Check if a request already exists
        $existingRequest = ReactiveAccountRequest::where('user_id', $userId)
            ->where('user_type', $userType)
            ->first();

        if ($existingRequest) {
            // Delete the existing request
            $existingRequest->delete();
        }

        // Create a new request
        $rq = new ReactiveAccountRequest();
        $rq->user_id = $userId;
        $rq->user_type = $userType;
        $rq->requested_at = now();
        $rq->save();

        // Redirect back with a success message
        return view('auth-verification.reactive-account-form', [
            'success_message' => 'Request for activating is sent, please wait Admin confirm!'
        ]);
    }

    public function getReactiveForm(Request $request) {
        $token = $request->token;
        $u_type = $request->u_type;
        return view('auth-verification.reactive-account-form', compact('token', 'u_type'));
    }

    public function writeLogContentViews(Request $request, ContentViewLoggerService $logger) {
        $result = $logger->logView($request->content_type, $request->content_id);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'content_id' => $request->content_id,
            'timestamp' => now()->toDateTimeString()
        ], $result['success'] ? 200 : 500);
    }

}
