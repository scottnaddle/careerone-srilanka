<?php

namespace App\Http\Controllers\CGO;

use App\Enums\JobStatusEnum;
use App\Enums\TypeTraineeApply;
use App\Enums\WorkingDayEnum;
use App\Exports\TraineeListExportCgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\JobSupport\OJT\OJTRegistrationRequest;
use App\Models\Company;
use App\Models\District;
use App\Models\DivisionalSecretariats;
use App\Models\Job;
use App\Models\NVQLevel;
use App\Models\OJT;
use App\Models\OjtTraineeApply;
use App\Models\Province;
use App\Models\Sector;
use App\Models\TraineeApply;
use App\Models\TraineeInstitute;
use App\Models\TraineeMatch;
use App\Models\TraineeUser;
use App\Services\Cgo\NotificationManager;
use App\Services\Company\JobVacancyService;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeJobService;
use Filament\Forms\Components\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class JobSupportController extends Controller
{

    protected TraineeJobService $traineeJobService;
    protected JobVacancyService $jobVacancyService;
    protected ProvincesDistrictsService $provincesDistrictsService;
    protected $notificationManager;


    public function __construct(TraineeJobService $traineeJobService, JobVacancyService $jobVacancyService, ProvincesDistrictsService $provincesDistrictsService,NotificationManager $notificationManager)
    {
        $this->middleware('cgo.auth');
        $this->traineeJobService = $traineeJobService;
        $this->jobVacancyService = $jobVacancyService;
        $this->provincesDistrictsService = $provincesDistrictsService;
        $this->notificationManager = $notificationManager;
    }

    public function traineeUserFilter(Request $request, $matched = null, $ojt_id = null)
    {
        $query = TraineeUser::query();
        //Chỉ lấy trainee có nhu cầu tìm việc
//        if(!auth('cgo')->check()){
            $query->where('active', true);
//            ->where('open_to_work', 1);
//        }

        // Nếu có ojt_id, lọc theo điều kiện có liên kết với ojtMatches
        if ($ojt_id) {
            $query->whereHas('ojtMatches', function ($query) use ($ojt_id) {
                $query->where('ojt_id', $ojt_id);
                $query ->where('apply_type','ojt_match');
            });
        }

        // Tìm kiếm dựa trên các trường username, first_name, và last_name
        if ($request->has('search') && $request->query('search') != '') {
            $searchTerm = '%' . $request->query('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query
                    ->where('first_name', 'ILIKE', $searchTerm)
                    ->orWhere('last_name', 'ILIKE', $searchTerm)
                    ->orWhere('full_name', 'ILIKE', $searchTerm)
                    ->orWhere('nic', 'ILIKE', $searchTerm)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
            });
        }
        if ($request->has('has-portfolio') && $request->query('has-portfolio') != '') {
            switch ($request->query('has-portfolio')) {
                case 1:
                    $query->whereIn('id', function ($subQuery) {
                        $subQuery->select('trainee_id')
                            ->from('portfolios')
                            ->whereNotNull('trainee_id');
                    });
                    break;
                case 2:
                    $query->whereNotIn('id', function ($subQuery) {
                        $subQuery->select('trainee_id')
                            ->from('portfolios')
                            ->whereNotNull('trainee_id');
                    });
                    break;
                case 'all':
                default:
                    break;
            }

        }

        // Lọc theo loại trainee
        if ($request->has('trainee_type') && $request->query('trainee_type') != 'all') {
            $traineeType = $request->query('trainee_type');
            if ($traineeType == 'keep') {
                $query->whereHas('keepTrainee', function ($query) {
                    $query->where('trainee_id', DB::raw('trainee_users.id'));
                });
            } elseif ($traineeType == 'unkeep') {
                $query->whereDoesntHave('keepTrainee');
            }
        }

        // Sắp xếp theo first_name
        return $query->orderBy('full_name', 'asc');
    }

    public function ojtDetail($id)
    {
        $ojt = OJT::where('id', $id)->firstOrFail();

        $companyList = Company::whereNotNull('verified_by')->whereNotNull('verified_by')->where('active',true)->get();
        return view('cgo.job-support.ojt-list.ojt-details')->with(['ojt' => $ojt, 'companyList' => $companyList]);
    }
    public function jobFilter(Request $request, $traineeId = null)
    {
        $query = Job::query()->where('status', 1); //get only job in progress

//        $query->where(function ($q) {
//            $q->whereNull('application_starttime')
//                ->orWhere('application_starttime', '>=', now()->toDateString());
//        });

        if ($request->has('title')) {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->has('sector') && $request->query('sector') != 'all') {
            $query->where('sector_id', $request->query('sector'));
        }

        if ($request->has('province') && $request->query('province') != '') {
            $query->whereHas('company.district', function ($q) use ($request) {
                $q->where('prov_id', $request->query('province'));

                if ($request->has('district') && $request->query('district') != '') {
                    $q->where('id', $request->query('district'));
                }
            });
        }

//        $orderDirection = in_array($request->query('job_type'), ['asc', 'desc'])
//            ? $request->query('job_type')
//            : 'desc';
        if ($request->has('job_type') && $request->query('job_type') != 'all') {
            if ($request->query('job_type') == 'match') {
                $query->whereIn('jobs.id', function ($query) use ($traineeId) {
                    $query->select('job_id')
                        ->from('trainee_matches')
                        ->where('trainee_id', $traineeId);
                });
            }elseif ($request->query('job_type') == 'unmatch') {
                $query->whereNotIn('jobs.id', function ($query) use ($traineeId) {
                    $query->select('job_id')
                        ->from('trainee_matches')
                        ->where('trainee_id', $traineeId);
                });
            }
        }

        if ($request->has('status') && $request->query('status') != '') {
            if ($request->query('status') == 'progress')
                $query->where('status', JobStatusEnum::PROGRESS);
            else if($request->query('status') == 'cancel'){
                $query->where('status', JobStatusEnum::CANCEL);
            }else if($request->query('status') == 'completed'){
                $query->where('status', JobStatusEnum::COMPLETED);
            }

        }

        if ($request->has('company_id') && $request->query('company_id') != '') {
            $query->where('company_id', $request->query('company_id'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function ojtFilter(Request $request, $traineeId = null)
    {
        $query = OJT::query();
        $query->where('status', 1);
        if ($request->has('title')) {
            $query->where('title', 'ilike', '%' . $request->query('title') . '%');
        }
        if ($request->has('nvq_level') && $request->nvq_level != '') {
            $nvqLevels = $request->query('nvq_level');
            if (is_array($nvqLevels)) {
                $query->whereIn('nvq_level', $nvqLevels);
            } else if ($nvqLevels != 'all') {
                $query->where('nvq_level', $nvqLevels);
            }
        }

        if ($request->has('province') && $request->query('province') != '') {
            $query->whereHas('company.district', function ($q) use ($request) {
                $q->where('prov_id', $request->query('province'));

                if ($request->has('district') && $request->query('district') != '') {
                    $q->where('id', $request->query('district'));
                }
            });
        }

        if ($request->has('sector')) {
            $sectors = $request->query('sector');
            if (is_array($sectors)) {
                $query->whereIn('sector_id', $sectors);
            } else if ($sectors != 'all') {
                $query->where('sector_id', $sectors);
            }
        }

        if ($request->has('job_type') && $request->query('job_type') != 'all') {
            if ($request->query('job_type') == 'match') {
                $query->whereHas('ojtMatches', function ($query) use ($traineeId) {
                    $query->where('trainee_id', $traineeId);
                });
            } elseif ($request->query('job_type') == 'unmatch') {
                $query->whereDoesntHave('ojtMatches', function ($query) use ($traineeId) {
                    $query->where('trainee_id', $traineeId);
                });
            }
        }

        if ($request->has('status') && $request->query('status') != '') {
            if ($request->query('status') == 'progress')
                $query->where('status', JobStatusEnum::PROGRESS);
            else if($request->query('status') == 'cancel'){
                $query->where('status', JobStatusEnum::CANCEL);
            }else if($request->query('status') == 'completed'){
                $query->where('status', JobStatusEnum::COMPLETED);
            }

        }

        if ($request->has('sort_by') && $request->query('sort_by') != '') {
            $query->orderBy('created_at',  $request->query('sort_by'));
        }

        if ($request->has('company_id') && $request->query('company_id') != '') {
            $query->where('company_id', $request->query('company_id'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function getProvinceAndDistrictById($provinceId, $districtId, $divisionalId)
    {
        if (!$provinceId) {
            return [null, null, null];
        }

        $province = Province::with('districts')->findOrFail($provinceId);

        if (!$districtId) {

            return [$province, null, null];
        }

        $district = District::with('divisionalSecretariats')->findOrFail($districtId);

        if (!$divisionalId) return [$province, $district, null];

        $divisional = DivisionalSecretariats::where('id', $divisionalId)->firstOrFail();

        return [$province, $district, $divisional];
    }


    public function companyFilter(Request $request)
    {
        $query = Company::query();
        $query->whereNotNull('verified_at')->whereNotNull('verified_by')->where('active', true);

        if ($request->has('company_name')) {
            $query->where('name', 'ILIKE', '%' . $request->query('company_name') . '%');
        }

        if ($request->has('province') && $request->query('province') != '') {
            $query->whereHas('district', function ($q) use ($request) {
                if ($request->has('province')) {
                    $q->where('prov_id', $request->query('province'));
                }
                if ($request->has('district') && $request->query('district') != '') {
                    $q->where('id', $request->query('district'));
                }
            });
        }

        if ($request->has('divisional_secretariat') && $request->query('divisional_secretariat') != 'all') {
            $query->where('ds_id', $request->has('divisional_secretariat'));
        }

        if ($request->has('company_information') && $request->query('company_information') != 'all') {
            $query->where('company_information', $request->query('company_information'));
        }
        if ($request->has('type_of_enterprise') && $request->query('type_of_enterprise') != 'all') {
            $query->where('enterprise_id', $request->query('type_of_enterprise'));
        }
        $query->orderBy('name', 'asc');
        return $query;
    }


    public function listTrainee(Request $request)
    {
        $query = $this->traineeUserFilter($request);

        $list_trainee_ids = TraineeInstitute::where('institute_id', auth('cgo')->user()->institute_id)
            ->groupBy('trainee_id')
            ->pluck('trainee_id');
        $query->whereIn('id', $list_trainee_ids);
        $traineeList = $query->paginate(10);
        $traineeList->appends($request->all());

        return view('cgo.job-support.trainee-list.trainee-list')
            ->with(['trainees' => $traineeList]);
    }

    public function exportTrainee(Request $request)
    {
        $export = new TraineeListExportCgo(
            $request,
            fn($req) => $this->traineeUserFilter($req) // truyền callback filter
        );

        return Excel::download($export, 'Trainee List.xlsx');
    }

    public function listCompany(Request $request)
    {
        $provinces = Province::get();
        foreach ($provinces as $province) {
            $province->districts =  District::where('prov_id', (string)$province->id)->get();

            foreach ($province->districts as $district) {
                $district->divisionalSecretariats = DivisionalSecretariats::where('dist_id', $district->id)->get();
            }
        };
        $query = $this->companyFilter($request);
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->getProvinceAndDistrictById($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'));
        $companies = $query->paginate(12);
        $companies->appends($request->all());
        $language = app()->getLocale();
        $companyInformations = getCodeList('company_information', $language);
        $typeOfEnterprises = getCodeList('Enterprise_Type', $language);
        return view('cgo.job-support.company-list.company-list')->with(['companyInformations' => $companyInformations, "companies" => $companies, 'provinces' => $provinces, 'provinceFilter' => $provinceFilter, 'districtsFilter' => $districtsFilter, 'divisionalFilter' => $divisionalFilter, 'typeOfEnterprises' => $typeOfEnterprises]);
    }
    public function listOJT(Request $request)
    {
        $query = $this->ojtFilter($request);
        $ojtLists = $query->paginate(10);
        $ojtLists->appends($request->all());
        $districts = District::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $nvqs = NVQLevel::all();
        $provinces = $this->provincesDistrictsService->getProvinces();
        $companies = Company::whereNotNull('verified_by')
        ->whereNotNull('verified_at')
        ->where('active', true)->get();
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->provincesDistrictsService->getProvinceAndDistrictById($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'));
        return view('cgo.job-support.ojt-list.ojt-list')->with(['companies' => $companies, 'ojts' => $ojtLists, 'districts' => $districts, 'sectors' => $sectors, 'nvqs' => $nvqs,  'provinceFilter', 'districtsFilter' => $districtsFilter, 'divisionalFilter' => $divisionalFilter, 'provinceFilter' => $provinceFilter]);
    }

    public function companyJobList($company, Request $request)
    {
        $company = Company::where('id', $company)->first();
        $jobsQuery = $company->jobRecruitings();

        if ($request->has('title')) {
            $jobsQuery->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->has('job_type')) {
            if ($request->query('job_type') == 'oldest')
                $jobsQuery->orderBy('application_starttime', 'asc');
            else $jobsQuery->orderBy('application_starttime', 'desc');
        } else {
            $jobsQuery->orderBy('application_starttime', 'desc');
        }

        $jobs = $jobsQuery->paginate(10)->appends($request->all());

        $sectors = Sector::orderBy('name', 'asc')->get();

        return view('cgo.job-support.company-list.job-list')->with(['company' => $company, 'sectors' => $sectors, 'jobs' => $jobs]);
    }
    public function companyJobListDetails($slug)
    {
        $jobDetail = Job::where('slug', $slug)->first();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        return view('cgo.job-support.company-list.job-details')->with(['jobDetail' => $jobDetail, 'sectors' => $sectors, 'districts' => $districts]);
    }

    public function OJTMatch(Request $request, $trainee)
    {
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        $traineeId = $trainee->id;
        $query = $this->ojtFilter($request, $traineeId);

        $ojts = $query->paginate(10);
        $districts = District::orderBy('name', 'asc')->get();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $ojts->appends($request->all());
        return view('cgo.job-support.trainee-list.ojt-match')->with(['trainee' => $trainee, 'ojts' => $ojts, 'sectors' => $sectors, 'districts' => $districts]);
    }

    public function jobMatch($id, Request $request)
    {
        $traineeUser = TraineeUser::where('id', $id)->first();

        $traineeId = $traineeUser->id;
        $query = $this->jobFilter($request, $traineeId);


        $jobs = $query->paginate(10);
        $jobs->appends($request->all());

        $sectors = Sector::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();

        return view('cgo.job-support.trainee-list.job-match')->with(["jobs" => $jobs, "trainee" => $traineeUser, "sectors" => $sectors, "districts" => $districts]);
    }

    public function jobDetails($trainee, $slug)
    {
        $jobDetail = Job::where(["slug" => $slug])->first();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        return view('cgo.job-support.trainee-list.job-details')->with(['trainee' => $trainee, "jobDetail" => $jobDetail, 'sectors' => $sectors, 'districts' => $districts]);
    }
    public function ojtDetails($trainee_id, $slug)
    {
        $job = null;
        $ojt = OJT::where('slug', $slug)->first();
        $working_day = WorkingDayEnum::getAllDay();
        $required_skills = [
            (object)['id' => 1, 'name' => 'English'],
            (object)['id' => 2, 'name' => 'Graduated'],
            (object)['id' => 3, 'name' => 'Leadership'],
        ];
        $sectors = Sector::orderBy('name', 'asc')->get();
        $ojt = OJT::where(['slug' => $slug])->first();
        return view('cgo.job-support.trainee-list.ojt-details')->with(['trainee_id' => $trainee_id, 'job' => $job, 'ojt' => $ojt, 'sectors' => $sectors, 'working_day' => $working_day, 'required_skills' => $required_skills]);
    }

    public function ojtListMatched(Request $request, $slug)
    {
        $ojt = OJT::where('slug', $slug)->first();

        if (!$ojt) {
            abort(404, 'OJT not found');
        }

        $OjtArray = OjtTraineeApply::where('ojt_id', $ojt->id)
            ->where('apply_type', 'ojt_match')
            ->pluck('trainee_id')
            ->toArray();

        $trainees = TraineeUser::whereIn('id', $OjtArray)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('full_name', 'ilike', '%' . $request->search . '%');
            })
            ->paginate(10);

        return view('cgo.job-support.ojt-list.list-matched', [
            'ojt' => $ojt,
            'trainees' => $trainees
        ]);
    }

    public function ojtListApplied(Request $request, $slug)
    {
        $ojt = OJT::where('slug', $slug)->first();

        if (!$ojt) {
            abort(404, 'OJT not found');
        }

        $OjtArray = OjtTraineeApply::where('ojt_id', $ojt->id)
            ->where('apply_type', 'apply')
            ->pluck('trainee_id')
            ->toArray();

        $trainees = TraineeUser::whereIn('id', $OjtArray)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('full_name', 'ilike', '%' . $request->search . '%');
            })
            ->paginate(10);

        return view('cgo.job-support.ojt-list.list-applied', [
            'ojt' => $ojt,
            'trainees' => $trainees
        ]);
    }

    public function ojtTraineeMatch(Request $request, $slug)
    {
        $query = $this->traineeUserFilter($request);

        $ojt = OJT::where(['slug' => $slug])->first();
        $list_trainee_ids = TraineeInstitute::where('institute_id', auth('cgo')->user()->institute_id)
        ->groupBy('trainee_id')
        ->pluck('trainee_id');
        $query->whereIn('id', $list_trainee_ids);
        $trainees = $query->paginate(10);
        $trainees->appends($request->all());
        return view('cgo.job-support.ojt-list.trainee-match')->with(['ojt' => $ojt, 'trainees' => $trainees]);
    }

    public function jobTraineeMatch(Request $request, $slug)
    {
        $query = $this->traineeUserFilter($request);

        $job = Job::where(['slug' => $slug])->first();
        $list_trainee_ids = TraineeInstitute::where('institute_id', auth('cgo')->user()->institute_id)
            ->groupBy('trainee_id')
            ->pluck('trainee_id');
        $query->whereIn('id', $list_trainee_ids);
        $trainees = $query->paginate(10);
        $trainees->appends($request->all());
        return view('cgo.job-support.job-list.trainee-match')->with(['job' => $job, 'trainees' => $trainees]);
    }
    public function ojtTraineeInformation($ojt, $trainee)
    {
        $ojt = OJT::where(['slug' => $ojt])->first();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        return view('cgo.job-support.ojt-list.trainee-information')->with(['trainee' => $trainee, 'ojt' => $ojt]);
    }
    public function ojtTraineeAppliedInformation($ojt, $trainee)
    {
        $ojt = OJT::where(['slug' => $ojt])->first();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        return view('cgo.job-support.ojt-list.trainee-applied-information')->with(['trainee' => $trainee, 'ojt' => $ojt]);
    }

    public function jobList(Request $request)
    {
        $query = $this->jobFilter($request);

        $jobs = $query->paginate(10);

        $provinces = $this->provincesDistrictsService->getProvinces();
        $sectors = Sector::get();

        $jobs->appends($request->all());
        $companies = Company::whereNotNull('verified_by')
            ->whereNotNull('verified_at')
            ->where('active', true)->get();
        [$provinceFilter, $districtsFilter, $divisionalFilter] = $this->provincesDistrictsService->getProvinceAndDistrictById($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'));
        [$sectorsFilter, $subsectorFilter] = $this->traineeJobService->getSectorAndSubSectorById($request->query('sector'), $request->query('subsector'));

        return view('cgo.job-support.job-list.job-list', compact('jobs', 'provinces', 'sectors', 'provinceFilter', 'districtsFilter', 'divisionalFilter', 'sectorsFilter', 'subsectorFilter', 'companies'));
    }

    public function jobListJobDetails($slug)
    {
        $jobDetail = Job::where("slug", $slug)->first();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        return view('cgo.job-support.job-list.job-details')->with(["jobDetail" => $jobDetail, "sectors" => $sectors, "districts" => $districts]);
    }

    public function ojtRegistration()
    {
        $currentCompany = Auth::guard('company')->check() ? Auth::guard('company')->user()->company_id : null;
        $companyList = Company::whereNotNull('verified_at')->whereNotNull('verified_by')->where('active',true)->get();

        return view('cgo.job-support.ojt-list.ojt-registration', compact('companyList', 'currentCompany'));
    }

    public function postOJTRegistration(OJTRegistrationRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        if (activeGuard() == 'cgo' && Auth::guard(activeGuard())->check()) {
            $data['registration_date'] = now();
            $data['application_starttime'] = $data['application_starttime'] != '' ? Carbon::parse($data['application_starttime'])->format('Y-m-d') : null;
            $data['application_endtime'] = $data['application_endtime'] != '' ? Carbon::parse($data['application_endtime'])->format('Y-m-d') : null;
            $data['slug'] = Str::slug($data['title']);
            $data['created_by'] = Auth::guard(activeGuard())->user()->id;
            $data['system'] = activeGuard();
            if (!isset($data['age_limitation'])) {
                $data['age_limitation'] = false;
            } else {
                $data['min_age'] = null;
                $data['max_age'] = null;
            }

            if (!isset($data['work_experience_limitation'])) {
                $data['work_experience_limitation'] = false;
            } else {
                $data['min_work_experience'] = null;
                $data['max_work_experience'] = null;
            }
            $currentDate = Carbon::now()->format('Y-m-d');
            $data['status'] = 1;
            if ($data['application_starttime'] && $data['application_endtime']) {
                if ($currentDate < $data['application_starttime'] || $currentDate > $data['application_endtime']) {
                    $data['status'] = 0;
                }
            }
            $ojt = OJT::create($data);
            return redirect()->route('cgo.job-support.ojt-list.list')->with('success', 'Create OJT successfully!');
        } else {
            return redirect()->route('cgo.job-support.ojt-list.list')->withInput()->withErrors('Can not create OJT or you do not have permission!');
        }
    }

    /**
     * Get list of candidate apply job vacancy
     *
     * @param Request $request
     * @param $job_id
     * @param $slug
     * @return View|RedirectResponse
     */
    public function getJobVacancyCandidateList(Request $request, $job_id, $slug = null): View|RedirectResponse
    {
        $job = $this->jobVacancyService->getJobVacancyById($job_id);
        $applies = $this->jobVacancyService->getTraineeApplyListByJobId($request, $job_id);

        if (empty($applies)) {
            return redirect()->route('company.job-support.job-vacancy.list');
        }


        return view('cgo.job-support.job-list.candidate-list', compact('applies', 'job'));
    }
    public function getJobVacancyMatchedList(Request $request, $job_id, $slug = null): View|RedirectResponse
    {
        $job = Job::where(['id' => $job_id])->first();
        $query = $this->traineeUserFilterForJobMatched($request, null, $job->id);
        $trainees = $query->paginate(10);
        return view('cgo.job-support.job-list.list-matched')->with(['job' => $job, 'trainees' => $trainees]);
    }

    public function getJobVacancyAppliedList(Request $request, $job_id, $slug = null): View|RedirectResponse
    {
        $job = Job::where(['id' => $job_id])->first();
        $query = $this->traineeUserFilterForJobApplied($request, null, $job->id);
        $trainees = $query->paginate(10);
        return view('cgo.job-support.job-list.list-applied')->with(['job' => $job, 'trainees' => $trainees]);
    }

    public function traineeUserFilterForJobMatched(Request $request, $matched = null, $job_id = null)
    {
        $query = TraineeUser::query();
        $query->where('active', true);
        //Chỉ lấy trainee có nhu cầu tìm việc
//        if(!auth('cgo')->check()) {
//            $query->where('open_to_work', 1);
//        }

        // Nếu có job_id, lọc theo điều kiện có liên kết với job matched
        if ($job_id) {
            $query->whereHas('jobMatches', function ($query) use ($job_id) {
                $query->where('job_id', $job_id);
            });
        }

        // Tìm kiếm dựa trên các trường username, first_name, và last_name
        if ($request->has('search') && $request->query('search') != '') {
            $searchTerm = '%' . $request->query('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query
                    ->where('first_name', 'ILIKE', $searchTerm)
                    ->orWhere('last_name', 'ILIKE', $searchTerm)
                    ->orWhere('full_name', 'ILIKE', $searchTerm)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
            });
        }

        // Lọc theo loại trainee
        if ($request->has('trainee_type') && $request->query('trainee_type') != 'all') {
            $traineeType = $request->query('trainee_type');
            if ($traineeType == 'keep') {
                $query->whereHas('keepTrainee', function ($query) {
                    $query->where('trainee_id', DB::raw('trainee_users.id'));
                });
            } elseif ($traineeType == 'unkeep') {
                $query->whereDoesntHave('keepTrainee');
            }
        }

        // Sắp xếp theo first_name
        return $query->orderBy('full_name', 'asc');
    }

    public function traineeUserFilterForJobApplied(Request $request, $matched = null, $job_id = null)
    {
        $query = TraineeUser::query();
        $query->where('active', true);

        // Nếu có job_id, lọc theo điều kiện có liên kết với job applied
        if ($job_id) {
            $query->whereHas('jobApplies', function ($query) use ($job_id) {
                $query->where('job_id', $job_id);
            });
        }

        // Tìm kiếm dựa trên các trường username, first_name, và last_name
        if ($request->has('search') && $request->query('search') != '') {
            $searchTerm = '%' . $request->query('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query
                    ->where('first_name', 'ILIKE', $searchTerm)
                    ->orWhere('last_name', 'ILIKE', $searchTerm)
                    ->orWhere('full_name', 'ILIKE', $searchTerm)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
            });
        }

        // Lọc theo loại trainee
        if ($request->has('trainee_type') && $request->query('trainee_type') != 'all') {
            $traineeType = $request->query('trainee_type');
            if ($traineeType == 'keep') {
                $query->whereHas('keepTrainee', function ($query) {
                    $query->where('trainee_id', DB::raw('trainee_users.id'));
                });
            } elseif ($traineeType == 'unkeep') {
                $query->whereDoesntHave('keepTrainee');
            }
        }

        // Sắp xếp theo first_name
        return $query->orderBy('full_name', 'asc');
    }

    public function storeJobMatched(Request $request)
    {
        $data = $request->all();
        $isMatch = TraineeMatch::where(['trainee_id' => $data['trainee_id'], 'job_id' => $data['job_id']])->get();
        $isApplyMatch = TraineeApply::where(['trainee_id' => $data['trainee_id'], 'job_id' => $data['job_id'], 'apply_type' => 'job_match'])->get();
        $job = Job::find($data['job_id']);

        if ($isMatch->isNotEmpty() || $isApplyMatch->isNotEmpty()) {
            try {
                // Delete both sets of records
                TraineeMatch::where(['trainee_id' => $data['trainee_id'], 'job_id' => $data['job_id']])->delete();
                TraineeApply::where(['trainee_id' => $data['trainee_id'], 'job_id' => $data['job_id'], 'apply_type' => 'job_match'])->delete();

                if ($request->redirect) {
                    return redirect()->route('cgo.job-support.job-list.list-matched', [
                        'job_id' => $job->id,
                        'slug' => $job->slug
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'You have unmatched this trainee!',
                    'action' => 'unmatch'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'code' => 201,
                    'message' => $e->getMessage(),
                    'action' => 'null'
                ]);
            }
        }
        $data['matched_time'] = now();
        $jobMatch = new TraineeMatch();
        $jobMatch->trainee_id = $data['trainee_id'];
        $jobMatch->job_id = $data['job_id'];
        $jobMatch->match_time = $data['matched_time'];
        $jobMatch->created_by = Auth::guard('cgo')->id();
        $jobMatch->save();

        $traineeApply = new TraineeApply();
        $traineeApply->job_id = $data['job_id'];
        $traineeApply->trainee_id = $data['trainee_id'];
        $traineeApply->apply_time = now();
        $traineeApply->read = null;
        $traineeApply->selected = null;
        $traineeApply->employeed = null;
        $traineeApply->selected_by = null;
        $traineeApply->apply_type = TypeTraineeApply::JOB_MATCH;
        $traineeUser= TraineeUser::find($data['trainee_id']);
//        $this->notificationManager->matchJobNotificationOfCgo($traineeUser, $job);
        $this->notificationManager->sendNotificationJobMatchToTrainee($job,$traineeApply);
        $this->notificationManager->sendNotificationJobMatchToCompany($traineeApply);
        $traineeApply->save();
        if ($request->redirect) {
            return redirect()->route('cgo.job-support.job-list.list-matched', ['job_id' => $job->id, 'slug' => $job->slug]);
        }
        return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have matched this trainee!', 'action' => 'match']);
    }

    public function jobTraineeInformation($ojt, $trainee)
    {
        $job = Job::where(['slug' => $ojt])->first();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        return view('cgo.job-support.job-list.trainee-information')->with(['trainee' => $trainee, 'job' => $job]);
    }

    public function jobTraineeAppliedInformation($ojt, $trainee)
    {
        $job = Job::where(['slug' => $ojt])->first();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        return view('cgo.job-support.job-list.trainee-applied-information')->with(['trainee' => $trainee, 'job' => $job]);
    }
}
