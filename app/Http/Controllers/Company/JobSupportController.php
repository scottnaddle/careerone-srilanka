<?php

namespace App\Http\Controllers\Company;

use App\Enums\JobStatusEnum;
use App\Enums\WorkingDayEnum;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\NVQLevel;
use App\Models\Portfolio;
use App\Models\Resume;
use App\Models\Sector;
use App\Http\Requests\Company\JobVacancyRequest;
use App\Models\Company;
use App\Models\TraineeTrainingHistory;
use App\Models\TraineeUserCV;
use App\Services\Company\JobVacancyService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\District;
use App\Models\Institute;
use App\Models\OJT;
use App\Models\TraineeApply;
use App\Models\TraineeUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Services\Trainee\NotificationManager;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeJobService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobSupportController extends Controller
{
    protected JobVacancyService $jobVacancyService;
    protected $notificationManager;
    protected TraineeJobService $traineeJobService;
    protected ProvincesDistrictsService $provincesDistrictsService;
    /**
     * JobSupportController constructor.
     *
     * @param JobVacancyService $jobVacancyService
     */
    public function __construct(JobVacancyService $jobVacancyService, NotificationManager $notificationManager, TraineeJobService $traineeJobService, ProvincesDistrictsService $provincesDistrictsService)
    {
        $this->middleware('company.auth')->except(['downloadFile']);
        $this->jobVacancyService = $jobVacancyService;
        $this->traineeJobService = $traineeJobService;
        $this->provincesDistrictsService = $provincesDistrictsService;
        $this->notificationManager = $notificationManager;
    }

    /**
     * Get job vacancy list
     *
     * @param Request $request
     * @return View
     */
    public function getJobVacancyList(Request $request): View
    {
        $jobs = $this->jobVacancyService->getJobVacancyListByCompanyId($request, auth()->guard('company')->user()->company_id);
        return view('company.job-support.job-vacancy.list', compact('jobs'));
    }

    /**
     * Show job vacancy detail
     *
     * @param $job_id
     * @param $slug
     * @return Application|Factory|View|RedirectResponse
     */
    public function showJobVacancy($job_id, $slug): Application|Factory|View|RedirectResponse
    {
        $working_day = WorkingDayEnum::getAllDay();


        $job = $this->jobVacancyService->getJobVacancyById($job_id);
        // dd($job);
        if (!$job || $job->company_id != auth()->guard('company')->user()->company_id) {
            return redirect()->route('company.job-support.job-vacancy.list');
        }
        //        dd($job);
        return view('company.job-support.job-vacancy.show', compact('job', 'working_day', 'slug'));
    }

    /**
     * Form create job vacancy
     *
     * @param Request $request
     * @return View
     */
    public function createJobVacancy(): View
    {
        $sectors = Sector::get();

        $working_day = WorkingDayEnum::getAllDay();

        $job = null; // Set default to avoid errors when using form with edit

        return view('company.job-support.job-vacancy.form', compact('sectors', 'working_day', 'job'));
    }

    /**
     * Create new job vacancy
     *
     * @param JobVacancyRequest $request
     * @return RedirectResponse
     */
    public function storeJobVacancy(JobVacancyRequest $request): RedirectResponse
    {
        $this->jobVacancyService->storeJobVacancy($request->all());

        return redirect()->route('company.job-support.job-vacancy.list')
            ->with('status', 'success')
            ->with('message', __('company.Published Job vacancy successfully'));
    }

    /**
     * Form edit job vacancy
     * @param $job_id
     * @return View|RedirectResponse
     */
    public function editJobVacancy($job_id): View|RedirectResponse
    {
        if (!$job_id || !$job = $this->jobVacancyService->getJobVacancyById($job_id)) {
            return redirect()->route('company.job-support.job-vacancy.list');
        }

        $sectors = Sector::get();
        $working_day = WorkingDayEnum::getAllDay();
        $states = JobStatusEnum::getAllStatus();

        return view('company.job-support.job-vacancy.form', compact('sectors', 'working_day', 'job', 'states'));
    }

    /**
     * Update job vacancy
     *
     * @param JobVacancyRequest $request
     * @param $job_id
     * @return RedirectResponse
     */
    public function updateJobVacancy(JobVacancyRequest $request, $job_id): RedirectResponse
    {
        $this->jobVacancyService->updateJobVacancy($request->all(), $job_id);
        return redirect()->route('company.job-support.job-vacancy.list')
            ->with('status', 'success')
            ->with('message', 'Job vacancy update successfully');
    }

    /**
     * Delete job vacancy
     *
     * @param Request $request
     * @param $job_id
     * @return RedirectResponse
     */
    public function deleteJobVacancy(Request $request, $job_id): RedirectResponse
    {
        if ($status = $this->jobVacancyService->deleteJobVacancy($job_id)) {
            return redirect()->route('company.job-support.job-vacancy.list')
                ->with('status', 'success')
                ->with('message', 'Job vacancy delete successfully');
        } else {
            return redirect()->route('company.job-support.job-vacancy.list')
                ->with('status', 'error')
                ->with('message', 'Something went wrong, please try again');
        }
    }

    /**
     * Get CV of trainee user
     *
     * @param $trainee_user_id
     * @return JsonResponse
     */
    public function getCVOfTrainee($trainee_user_id): JsonResponse
    {

        $traineeUser = TraineeUser::where('id', $trainee_user_id)->first();
        $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $trainee_user_id)->first();
        $traineeResume = Resume::where('trainee_id', $trainee_user_id)->get();
        $traineePortfolio = Portfolio::where('trainee_id', $traineeUser->id)->first();
        $traineeUser->sumary_training = getSumaryTraining($traineeUser->id);
        $traineeBasicInformation = array();
        if ($traineeTrainingInformations) {
            $trainingInformations = json_decode($traineeTrainingInformations->content);
            $trainingCertificates = $traineeTrainingInformations->nvq_content != null ? json_decode($traineeTrainingInformations->nvq_content) : null;

            foreach ($trainingInformations as $key => $trainingInformation) {
                $traineeBasicInformation[$key]['certificate'] = $trainingInformation->NVQ_QUALIFICATION;
                $traineeBasicInformation[$key]['education'] = $trainingInformation->COURSE;
                $traineeBasicInformation[$key]['institute'] = $trainingInformation->INSTITUTE;
            }
            return response()->json([
                'trainee_user' => $traineeUser,
                'trainee_information' => $traineeBasicInformation,
                'trainee_certificates' => $trainingCertificates,
                'trainee_resume' => $traineeResume,
                'trainee_portfolio' => $traineePortfolio ? route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $traineePortfolio->id]) : '',
                'trainee_portfolio_public' => $traineeUser->public_portfolio,
            ]);
        }else {
            return response()->json([
                'trainee_user' => $traineeUser,
                'trainee_information' => null,
                'trainee_certificates' => null,
                'trainee_resume' => $traineeResume,
                'trainee_portfolio' => $traineePortfolio ? route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $traineePortfolio->id]) : '',
                'trainee_portfolio_public' => $traineeUser->public_portfolio,
            ]);
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


        return view('company.job-support.job-vacancy.candidate-list', compact('applies', 'job'));
    }

    /**
     * Show all trainee apply in my company
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function getCandidateList(Request $request): View|RedirectResponse
    {
        $applies = $this->jobVacancyService->getTraineeApplyListByCompanyId($request, auth()->guard('company')->user()->company_id);
        $job = null;
        return view('company.job-support.job-vacancy.candidate-list', compact('applies', 'job'));
    }

    /**
     * Update status read trainee CV
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatusReadTraineeCV(Request $request)
    {
        try {
            $trainee_apply_id = $request->request->get('trainee_apply_id');
            $traineeApply = TraineeApply::find($trainee_apply_id);
            if (!$traineeApply) {
                return response()->json(['status' => 'error', 'message' => 'Record not found']);
            }
            $trainee_id = $traineeApply->trainee_id;
            $job_id = $traineeApply->job_id;

            TraineeApply::where('trainee_id', $trainee_id)
                ->where('job_id', $job_id)
                ->update(['read' => now()]);
            return response()->json(['status' => 'success', 'message' => 'Update status read CV success']);
        } catch (\Exception $e) {
            Log::error('Error when update status read CV: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error when update status read CV']);
        }
    }

    /**
     * Selected trainee apply job vacancy
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function selectedTraineeApply(Request $request)
    {

        try {
            $trainee_apply_id = $request->request->get('trainee_apply_id');
            $traineeApply = TraineeApply::with(['job', 'user'])->find($trainee_apply_id);
            if (!$traineeApply) {
                return response()->json(['status' => 'error', 'message' => 'Record not found']);
            }
            $trainee_id = $traineeApply->trainee_id;
            $job_id = $traineeApply->job_id;
            $traineeApply['username_company'] = auth('company')->user()?->fullName;
            $this->notificationManager->sendSelectedTraineeApplyNotification($traineeApply);
            TraineeApply::where('trainee_id', $trainee_id)
                ->where('job_id', $job_id)
                ->update(['selected' => now(), 'selected_by' => auth()->guard('company')->user()->id,
                    'unselect_at' => null]);
            return response()->json(['status' => 'success', 'message' => 'Selected trainee apply success']);
        } catch (\Exception $e) {
            Log::error('Error when selected trainee apply: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error when selected trainee apply']);
        }
    }

    /**
     * Unselected trainee apply job vacancy
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unselectedTraineeApply(Request $request)
    {
        try {
            $trainee_apply_id = $request->request->get('trainee_apply_id');
            $traineeApply = TraineeApply::find($trainee_apply_id);
            if (!$traineeApply) {
                return response()->json(['status' => 'error', 'message' => 'Record not found']);
            }
            $trainee_id = $traineeApply->trainee_id;
            $job_id = $traineeApply->job_id;

            TraineeApply::where('trainee_id', $trainee_id)
                ->where('job_id', $job_id)
                ->update(['selected' => null, 'selected_by' => null,'unselect_at' => now()]);
            return response()->json(['status' => 'success', 'message' => 'Unselected trainee apply success']);
        } catch (\Exception $e) {
            Log::error('Error when unselected trainee apply: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error when unselected trainee apply']);
        }
    }

    /**
     * Employeed trainee apply job vacancy
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function employeedTraineeApply(Request $request)
    {
        try {
            $trainee_apply_id = $request->request->get('trainee_apply_id');
            $traineeApply = TraineeApply::with(['job', 'user'])->find($trainee_apply_id);
            if (!$traineeApply) {
                return response()->json(['status' => 'error', 'message' => 'Record not found']);
            }
            $trainee_id = $traineeApply->trainee_id;
            $job_id = $traineeApply->job_id;
            $company = Company::where('id', auth()->guard('company')->user()->company_id)->first();
            $company_name = $company->name;
            // auth()->guard('company')->user()->first_name.' '.auth()->guard('company')->user()->last_name;
            $traineeApply['username_company'] = $company_name;
            $this->notificationManager->sendEmployeedTraineeApplyNotification($traineeApply);
            TraineeApply::where('trainee_id', $trainee_id)
                ->where('job_id', $job_id)
                ->update(['employeed' => now()]);
            $job = Job::where('id', $job_id)->first();
            if ($job) {
                //If employeed == number of recruitment job => change status = 2
                $countEmployeed = TraineeApply::where('job_id', $job_id)->whereNotNull('employeed')->count();
                if ($countEmployeed == $job->number_of_recruitments) {
                    $job->status = JobStatusEnum::COMPLETED->value;
                    $job->save();
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Unselected trainee apply success']);
        } catch (\Exception $e) {
            Log::error('Error when employeed trainee apply: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error when employeed trainee apply']);
        }
    }

    /**
     * Return file to download
     *
     * @param $job_id
     * @param $filename
     * @return RedirectResponse|BinaryFileResponse
     */
    public function downloadFile($job_id, $filename): BinaryFileResponse|RedirectResponse
    {
        $filePath = storage_path("app/public/company/job_vacancy_attachments/{$job_id}/{$filename}");

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function traineeUserFilter(Request $request)
    {
        $query = TraineeUser::query();

        $query->where('active', true)
        ->where('public_portfolio', 1);
//        ->where('open_to_work', 1);
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

        if ($request->has('institute') && $request->query('institute') != 'all' && $request->institute != '') {
            $institute_id = $request->institute;
            $query->whereHas('institutes', function ($q) use ($institute_id) {
                $q->where('institutes.id', $institute_id);
            });
        }

        if ($request->has('nvq_level') && $request->query('nvq_level') != 'all' && $request->nvq_level != '') {
            $nvq_id = $request->nvq_level;
            $query->whereHas('nvqs', function ($q) use ($nvq_id) {
                $q->where('n_v_q_levels.id', $nvq_id);
            });
        }

        //        if ($request->has('province') && $request->query('province') != '') {
        //            $query->whereHas('district', function ($query) use ($request) {
        //                if ($request->has('province')) {
        //                    $query->where('prov_id', $request->query('province'));
        //                }
        //                if ($request->has('district') && $request->query('district') != '') {
        //                    $query->where('id', $request->query('district'));
        //                }
        //            });
        //        }


        // Sort by first_name
        return $query->orderBy('first_name', 'asc');
    }

    public function traineeList(Request $request)
    {
        $language = app()->getLocale();
        $query = $this->traineeUserFilter($request);
        $sectors = Sector::get();
        [$provinceFilter, $districtsFilter, $divisionalFilter, $instituteFilter] = $this->provincesDistrictsService->getInstituteByAnotherField($request->query('province'), $request->query('district'), $request->query('divisional_secretariat'), $request->query('ownership'), $request->query('activeStatus'), $request->query('institute'));
        [$sectorsFilter, $subsectorFilter] = $this->traineeJobService->getSectorAndSubSectorById($request->query('sector'), $request->query('subsector'));
        $provinces = $this->provincesDistrictsService->getProvinces();
        $nvqLevels = NVQLevel::orderBy('name')->get();
        $institutes = Institute::where('active_status', 'ILIKE', 'Active')->orderBy('name', 'asc')->get();
        $trainees = $query->paginate(10);
        $ownerships = getCodeList('ownership', $language);
        $chooseInstitute = Institute::where('id', $request->institute)->first();

        $trainees->appends($request->all());

        return view('company.job-support.trainee-list.trainee-list')->with([
            'nvqs' => $nvqLevels,
            'trainees' => $trainees,
            'provinceFilter' => $provinceFilter,
            'districtsFilter' => $districtsFilter,
            'divisionalFilter' => $divisionalFilter,
            'instituteFilter' => $instituteFilter,
            'sectorsFilter' => $sectorsFilter,
            'subsectorFilter' => $subsectorFilter,
            'provinces' => $provinces,
            'sectors' => $sectors,
            'institutes' => $institutes,
            'ownerships' => $ownerships,
            'chooseInstitute' => $chooseInstitute
        ]);
    }

    public function ojtList(Request $request)
    {
        $user = Auth::guard(activeGuard())->user();
        $query = OJT::query()->where('company_id', $user->company_id);
        if ($request->has('title') && $request->query('title') != '') {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->has('status') && $request->query('status') != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('sort_by') && $request->query('sort_by') != '') {
            $query->orderBy('created_at',  $request->query('sort_by'));
        }else {
            $query->orderBy('created_at', 'desc');
        }

        $ojtList = $query->paginate(10);

        return view('company.job-support.ojt-list.ojt-list')->with(['ojts' => $ojtList]);
    }

    public function ojtRegistration()
    {
        $currentRecruiter = Auth::guard('company')->user();
        $currentCompany = $currentRecruiter ? $currentRecruiter->company_id : null;

        $isHeadquarter = $currentRecruiter && optional($currentRecruiter->company)->office_type == 1;

        if ($isHeadquarter && $currentCompany) {
            $companyList = Company::whereNotNull('verified_at')
                ->whereNotNull('verified_by')
                ->where('active', true)
                ->where('headquarter_id', $currentCompany)
                ->get();
            // Append the current company to the collection
            $companyList->push(Company::find($currentCompany));
        } else {
            $companyList = Company::where('id', $currentCompany)
                ->get();
        }

        return view('company.job-support.ojt-list.ojt-registration', compact('companyList', 'currentCompany', 'isHeadquarter'));
    }

    public function ojtDetail($slug)
    {
        $ojt = OJT::where('slug', $slug)->first();
        $companyList = Company::whereNotNull('verified_at')->whereNotNull('verified_by')->where('active',true)->get();
        return view('company.job-support.ojt-list.ojt-details')->with(['ojt' => $ojt, 'companyList' => $companyList]);
    }

    public function ojtEdit($slug)
    {
        $ojt = OJT::where('slug', $slug)->first();
        $currentRecruiter = Auth::guard('company')->user();
        $currentCompany = $currentRecruiter ? $currentRecruiter->company_id : null;

        $isHeadquarter = $currentRecruiter && optional($currentRecruiter->company)->office_type == 1;

        if ($isHeadquarter && $currentCompany) {
            $companyList = Company::whereNotNull('verified_at')
                ->whereNotNull('verified_by')
                ->where('active', true)
                ->where('headquarter_id', $currentCompany)
                ->get();
            // Append the current company to the collection
            $companyList->push(Company::find($currentCompany));
        } else {
            $companyList = Company::where('id', $currentCompany)
                ->get();
        }
        return view('company.job-support.ojt-list.ojt-edit')->with(['ojt' => $ojt, 'companyList' => $companyList, 'isHeadquarter' => $isHeadquarter]);
    }

    public function ojtCandidateList(Request $request, $slug)
    {
        $ojt = OJT::where('slug', $slug)->first();

        $query = $ojt->applies();
        if ($request->has('search') && $request->query('search') != '') {
            $query->whereHas('traineeMatched', function ($q) use ($request) {
                $searchTerm = '%' . $request->query('search') . '%';
                $q->where(function ($query) use ($searchTerm) {
                    $query
                        ->where('first_name', 'ILIKE', $searchTerm)
                        ->orWhere('last_name', 'ILIKE', $searchTerm)
                        ->orWhere('full_name', 'ILIKE', $searchTerm)
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
                });
            });
        }

        $allApplies = $query->get();

        $groupedApplies = [];
        $uniqueTraineeIds = [];

        foreach ($allApplies as $apply) {
            $traineeId = $apply->trainee_id;

            if (!isset($groupedApplies[$traineeId])) {
                $groupedApplies[$traineeId] = [
                    'apply' => null,
                    'matched' => null,
                    'data' => $apply
                ];
                $uniqueTraineeIds[] = $traineeId;
            }

            if ($apply->checkOjtTraineeApply($traineeId, $apply->ojt_id)) {
                $groupedApplies[$traineeId]['apply'] = $apply;
                $groupedApplies[$traineeId]['data'] = $apply;
            }
            if (!empty($apply->matched_by)) {
                $groupedApplies[$traineeId]['matched'] = $apply;
                if (!$groupedApplies[$traineeId]['apply']) {
                    $groupedApplies[$traineeId]['data'] = $apply;
                }
            }
        }
        $collection = collect(array_values(array_map(function($item) {
            return $item['data'];
        }, $groupedApplies)));
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $paginatedItems = $collection->slice($offset, $perPage)->all();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems,
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        session(['grouped_applies' => $groupedApplies]);

        return view('company.job-support.ojt-list.candidate-list')->with([
            'ojt' => $ojt,
            'applies' => $paginator,
            'groupedApplies' => $groupedApplies
        ]);
    }
    public function ojtTraineeInformation($ojt, $trainee)
    {
        $ojt = OJT::where(['slug' => $ojt])->first();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        return view('company.job-support.ojt-list.trainee-information')->with(['trainee' => $trainee, 'ojt' => $ojt]);
    }

}
