<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Enums\ApiResponseStatusEnums;
use App\Enums\Trainee\ApplyTypeEnums;
use App\Enums\Trainee\BookmarkTypeEnums;
use App\Enums\TypeTraineeApply;
use App\Models\Company;
use App\Models\CompanyBookmark;
use App\Models\Job;
use App\Models\OJT;
use App\Models\OjtBookmark;
use App\Models\OjtTraineeApply;
use App\Services\Company\JobVacancyService;
use App\Services\Trainee\JobBookmarkService;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeAppliesService;
use App\Services\Trainee\TraineeJobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class JobSupportController extends BaseController
{
    protected TraineeJobService $traineeJobService;
    protected JobVacancyService $jobVacancyService;
    protected jobBookmarkService $jobBookmarkService;
    protected TraineeAppliesService $traineeAppliesService;
    protected ProvincesDistrictsService $provincesDistrictsService;

    public function __construct(TraineeJobService $traineeJobService, JobVacancyService $jobVacancyService, JobBookmarkService $jobBookmarkService, TraineeAppliesService $traineeAppliesService, ProvincesDistrictsService $provincesDistrictsService)
    {
        $this->traineeJobService = $traineeJobService;
        $this->jobVacancyService = $jobVacancyService;
        $this->jobBookmarkService = $jobBookmarkService;
        $this->traineeAppliesService = $traineeAppliesService;
        $this->provincesDistrictsService = $provincesDistrictsService;
    }
    public function getCompanyList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $id = $request->has('id') ? $request->id : '';
        $orderBy = $request->has('sort_by') ? $request->sort_by : 'desc';
        $companies = Company::query();
        $companies->whereNotNull('verified_at')->whereNotNull('verified_by')->where('active', true);
        $trainee_id = Auth::guard('sanctum')->user()->id;

        if ($id) {
            $company = $companies->where('id', $id)
                ->with(['district', 'jobs' => function ($query) {
                    $query->where('status', 1);
                }, 'events'])
                ->first();

            if ($company) {
                $company->isBookmark = $company->bookmarks->where('trainee_id', $trainee_id)->isNotEmpty();
//                $company->enterprise = getCodeNameByCodeId('Enterprise_Type', $company->enterprise_id);
                $company->jobs->transform(function ($job) use ($trainee_id) {
                    $job->isBookmark = $job->bookmarks->where('trainee_id', $trainee_id)->isNotEmpty();
                    $job->isApply = $job->applies->where('trainee_id', $trainee_id)->isNotEmpty();
//                    $job->gender = is_array($job->gender) ? null : getCodeNameByCodeId('gender', (int) $job->gender);
//                    $job->job_type = getCodeNameByCodeId('job_type', $job->job_type);
//                    $job->job_location = getCodeNameByCodeId('job_location', $job->job_location);
                    $job->company_logo = filter_var($job->company->logo, FILTER_VALIDATE_URL) ? $job->company->logo : (file_exists($job->company->logo) ? asset($job->company->logo) : '');
                    return $job;
                });

                $company->events->transform(function ($event) use ($trainee_id) {
                    $event->load(['attachments']);
                    $event->author_name = $event->author->fullName;
                    foreach ($event->attachments as $attachment) {
                        $attachment->path = asset($attachment->path);
                    }
//                    $event->event_type = getCodeNameByCodeId('event_type', $event->event_type);
                    $event->thumbnail = asset($event->thumbnail);
                    return $event;
                });
//                $company->company_information=getCodeNameByCodeId('company_information', $company->company_information);

                return $this->sendResponse($company, ['message' => 'Company data retrieved successfully!']);
            }
            return $this->sendError('Company not found');
        }

        if ($keyword) {
            $companies->where('name', 'LIKE', '%' . $keyword . '%');
        }

        if ($orderBy)
            $companies->orderBy('created_at', $orderBy);
        $companies->with([
            'district',
            'jobs' => function ($query) {
                $query->where('status', 1);
            },
            'events'
        ]);

        if ($request->has('bookmark') && $request->query('bookmark') != '' && $request->query('bookmark') != 'all') {
            $bookmarkStatus = $request->query('bookmark');

            $companies->where(function ($subQuery) use ($bookmarkStatus, $trainee_id) {
                if ($bookmarkStatus === 'mark') {
                    $subQuery->whereHas('bookmarks', function ($q) use ($trainee_id) {
                        $q->where('trainee_id', $trainee_id);
                    });
                } else {
                    $subQuery->whereDoesntHave('bookmarks', function ($q) use ($trainee_id) {
                        $q->where('trainee_id', $trainee_id);
                    });
                }
            });
        }

        if ($request->has('province') && $request->query('province') != '') {
            $companies->whereHas('district', function ($q) use ($request) {
                if ($request->has('province')) {
                    $q->where('prov_id', $request->query('province'));
                }
                if ($request->has('district') && $request->query('district') != '') {
                    $q->where('id', $request->query('district'));
                }
            });
        }

        if ($request->has('divisional_secretariat') && $request->query('divisional_secretariat') != 'all' && $request->query('divisional_secretariat') != '') {
            $companies->where('ds_id', $request->has('divisional_secretariat'));
        }

        if ($request->has('sector') && $request->query('sector') != '') {
            $sectorId = $request->query('sector');
            $companies->whereHas('jobs', function ($q) use ($sectorId) {
                $q->where('sector_id', $sectorId);
            });
        }

        if ($request->has('company_information') && $request->query('company_information') != 'all') {
            $companies->where('company_information', $request->query('company_information'));
        }


        $total = $companies->count();

        $companies = $companies->paginate(10);
        $companies->getCollection()->transform(function ($company) use ($trainee_id) {
//            $company->company_information=getCodeNameByCodeId('company_information', $company->company_information);
//            $company->enterprise = getCodeNameByCodeId('Enterprise_Type', $company->enterprise_id);
            $company->isBookmark = $company->bookmarks->where('trainee_id', $trainee_id)->isNotEmpty();
            // $company->logo = env('APP_URL') . $company->logo;
            $company->jobs->transform(function ($job) use ($trainee_id) {
                $job->isBookmark = $job->bookmarks->where('trainee_id', $trainee_id)->isNotEmpty();
                $job->isApply = $job->applies->where('trainee_id', $trainee_id)->isNotEmpty();
//                $job->gender = is_array($job->gender) ? null : getCodeNameByCodeId('gender', (int) $job->gender);
//                $job->job_type = getCodeNameByCodeId('job_type', $job->job_type);
//                $job->job_location = getCodeNameByCodeId('job_location', $job->job_location);
                $job->company_logo = filter_var($job->company->logo, FILTER_VALIDATE_URL) ? $job->company->logo : (file_exists($job->company->logo) ? asset($job->company->logo) : '');
                unset($job->bookmarks);
                unset($job->applies);
                return $job;
            });

            $company->events->transform(function ($event) use ($trainee_id) {
                $event->load(['attachments']);
                $event->author_name = $event->author->fullName;
                foreach ($event->attachments as $attachment) {
                    $attachment->path = asset($attachment->path);
                }
//                $event->event_type = getCodeNameByCodeId('event_type', $event->event_type);
                $event->thumbnail =  asset($event->thumbnail);
                return $event;
            });

            return $company;
        });

        // Prepare the response data
        $data['total'] = $total;
        $data['data'] = $companies;

        return $this->sendResponse($data, ['message' => 'Company data retrieved successfully!']);
    }



    public function getJobList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $id = $request->has('id') ? $request->id : '';
        $sector = $request->has('sector') ? $request->sector : '';
        $orderBy = $request->has('sort_by') ? $request->sort_by : 'desc';
        $jobs = Job::query()->where('status', 1)->with(['companyRecruiter']);
        if ($id) {
            $job = $jobs->where('id', $id)->with(['company', 'sector', 'district', 'companyRecruiter'])->first();
            $owner = $job->companyRecruiter;
            $job->creator_first_name = $owner->first_name;
            $job->creator_last_name = $owner->last_name;
            $job->gender = is_array($job->gender) ? null : getCodeNameByCodeId('gender', (int) $job->gender);
            $job->job_type = getCodeNameByCodeId('job_type', $job->job_type);
            $job->job_location = getCodeNameByCodeId('job_location', $job->job_location);
            $data['data'] = $job;
            return $this->sendResponse($data, ['message', 'Job data retrive successfull!']);
        }
        if ($keyword) {
            $jobs->where('title', 'ILIKE', '%' . $keyword . '%');
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
        if ($sector) {
            $jobs->where('sector_id', $sector);
        }
        if ($orderBy) {
            $jobs->orderBy('created_at', $orderBy);
        }
        $currentDateTime = Carbon::now();
        $jobs->where('application_starttime', '<=', $currentDateTime)->where('application_endtime', '>=', $currentDateTime); //is recruiting
        $total = $jobs->count();
        $jobs = $jobs->with(['company', 'sector', 'district'])->paginate(10);
        $data['total'] = $total;
        $data['data'] = $jobs;
        return $this->sendResponse($data, ['message', 'Job datas retrive successfull!']);
    }
    public function getTraineeApplyByOJTId($id)
    {
        $trainee_id = auth()->guard('sanctum')->user()->id;
        return OjtTraineeApply::where('trainee_id', $trainee_id)->where('ojt_id', $id)->where('apply_type', TypeTraineeApply::APPLY->value)->first();

    }

    public function getTraineeMatchedByOJTId($id)
    {
        $trainee_id = auth()->guard('sanctum')->user()->id;
        return OjtTraineeApply::where('trainee_id', $trainee_id)->where('ojt_id', $id)->where('apply_type', TypeTraineeApply::OJT_MATCH->value)->first();

    }
    public function getOjtList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $id = $request->has('id') ? $request->id : '';
        $sector = $request->has('sector') ? $request->sector : '';
        $orderBy = $request->has('sort_by') ? $request->sort_by : 'desc';
        $nvqLevel = $request->has('nvq_level') ? $request->nvq_level : '';
        $ojts = OJT::query();
        $trainee_id = Auth::guard('sanctum')->user()->id;
        if ($id) {
            $ojt = $ojts->where('id', $id)->with(['company', 'sector', 'district'])->first();
//            $ojt->gender = is_array($ojt->gender) ? null : getCodeNameByCodeId('gender', (int) $ojt->gender);
            $owner = $ojt->owner;
            $ojt->company->logo=  $owner->company->logo ? asset($owner->company->logo) : '';
            $ojt->creator_first_name = $owner->first_name;
            $ojt->creator_last_name = $owner->last_name;
            if ($trainee_id) {
                $ojt->is_apply   = $ojt->isApplyByTrainee($trainee_id) ? true : false;
                $ojt->is_matched = $ojt->isMatchedByCgo($trainee_id) ? true : false;

                $status = null;

                if ($ojt->is_apply) {
                    $traineeApply = $this->getTraineeApplyByOJTId($ojt->id);

                    if ($traineeApply) {
                        if ($traineeApply->employeed) {
                            $status = 'Employeed';
                        } elseif ($traineeApply->selected) {
                            $status = 'Selected';
                        } else {
                            $status = 'Applied';
                        }
                    }
                }

                if ($ojt->is_matched && !$status) { // chỉ gán nếu chưa có status
                    $traineeMatched = $this->getTraineeMatchedByOJTId($ojt->id);

                    if ($traineeMatched) {
                        if ($traineeMatched->employeed) {
                            $status = 'Employeed';
                        } elseif ($traineeMatched->selected) {
                            $status = 'Selected';
                        } else {
                            $status = 'Matched';
                        }
                    }
                }

                $ojt->statusApply = $status;
            }
            return $this->sendResponse($ojt, ['message', 'OJT data retrieve successfully!']);
        }
        if ($keyword) {
            $ojts->where('title', 'ILIKE', '%' . $keyword . '%');
        }

        if ($request->has('province') && $request->query('province') != '') {
            $ojts->whereHas('company.district', function ($query) use ($request) {
                if ($request->has('province')) {
                    $query->where('prov_id', $request->query('province'));
                }
                if ($request->has('district') && $request->query('district') != '') {
                    $query->where('id', $request->query('district'));
                }
            });
        }
        if ($sector) {
            $ojts->where('sector_id', $sector);
        }
        if ($orderBy) {
            $ojts->orderBy('created_at', $orderBy);
        }
        if ($nvqLevel) {
            $ojts->where('nvq_level', $nvqLevel);
        }

        if ($request->has('bookmark') && $request->query('bookmark') != 'all') {
            $bookmarkStatus = $request->query('bookmark');

            $ojts->where(function ($subQuery) use ($bookmarkStatus, $trainee_id) {
                if ($bookmarkStatus === 'mark') {
                    $subQuery->whereHas('bookmarks', function ($q) use ($trainee_id) {
                        $q->where('trainee_id', $trainee_id);
                    });
                } else {
                    $subQuery->whereDoesntHave('bookmarks', function ($q) use ($trainee_id) {
                        $q->where('trainee_id', $trainee_id);
                    });
                }
            });
        }
        if ($trainee_id) {
            $ojts->selectRaw('o_j_t_s.*, (
                SELECT CASE WHEN COUNT(*) > 0 THEN true ELSE false END
                FROM ojt_trainee_applies
                WHERE ojt_trainee_applies.ojt_id = o_j_t_s.id
                  AND apply_type = ?
                  AND trainee_id = ?
            ) as is_apply', [TypeTraineeApply::APPLY->value, $trainee_id]);
        }
        // Lọc theo trạng thái job (applied hoặc matched)
        if ($statusOjt = $request->query('status_ojt')) {
            match ($statusOjt) {
                'applied' => $ojts->whereIn('o_j_t_s.id', function ($q) use ($trainee_id) {
                    $q->select('ojt_id')->from('ojt_trainee_applies')
                        ->where('trainee_id', $trainee_id)
                        ->where('apply_type', \App\Enums\TypeTraineeApply::APPLY);
                }),
                'matched' => $ojts->whereIn('o_j_t_s.id', function ($q) use ($trainee_id) {
                    $q->select('ojt_id')->from('ojt_trainee_applies')
                        ->where('trainee_id', $trainee_id)
                        ->where('apply_type', \App\Enums\TypeTraineeApply::OJT_MATCH);
                }),
                default => $ojts->where('status', 1)
            };
        } else {
            $ojts->where('status', 1);
        }


        // Lọc theo status
        if ($request->filled('status')) {
            $ojts->where('status', $request->query('status'));
        }


        $ojts = $ojts->with(['company', 'sector', 'district', 'owner'])->paginate(10);

        $ojts->getCollection()->transform(function ($ojt) use ($trainee_id) {
            $ojt->isBookmark = $ojt->bookmarks->where('trainee_id', $trainee_id)->isNotEmpty();
            $owner = $ojt->owner;
            $ojt->company->logo=  $owner->company->logo ? asset($owner->company->logo) : '';
            $ojt->creator_first_name = $owner->first_name;
//            $ojt->gender = is_array($ojt->gender) ? null : getCodeNameByCodeId('gender', (int) $ojt->gender);
            $ojt->creator_last_name = $owner->last_name;
            return $ojt;
        });

        $total = $ojts->count();
        $data['total'] = $total;
        $data['data'] = $ojts;
        return $this->sendResponse($data, ['message', 'OJT datas retrive successfull!']);
    }

    public function bookmarkCompany(Request $request)
    {
        $dataRequest = $request->all();
        $message = '';
        $dataRequest['trainee_id'] = Auth::guard('sanctum')->user()->id;
        $marked = CompanyBookmark::where('trainee_id', Auth::guard('sanctum')->user()->id)
            ->where('company_id', $dataRequest['company_id'])
            ->first();
        $status = ApiResponseStatusEnums::OK;
        if ($marked) {
            $marked->delete();
            $data['type'] = BookmarkTypeEnums::UNMARK;
            $message = 'Unmark company successfully!';
        } else {
            $data['type'] = BookmarkTypeEnums::MARK;
            $message = 'Bookmark company successfully!';
            DB::beginTransaction();
            try {
                $companyBookmark = CompanyBookmark::create($dataRequest);
                $data['companybookmark'] = $companyBookmark;
                $status = ApiResponseStatusEnums::CREATED;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'status' => $status->value
        ]);
    }

    public function toggleOJTBookmark(Request $request)
    {
        $dataRequest = $request->all();
        $dataRequest['trainee_id'] = Auth::guard('sanctum')->user()->id;
        $marked = OjtBookmark::where('trainee_id', Auth::guard('sanctum')->user()->id)->where('ojt_id', $dataRequest['ojt_id'])->first();
        $status = ApiResponseStatusEnums::OK;
        if ($marked) {
            $marked->delete();
            $data['type'] = BookmarkTypeEnums::UNMARK;
        } else {
            $data['type'] = BookmarkTypeEnums::MARK;
            DB::beginTransaction();
            try {
                $ojtBookmark = OjtBookmark::create($dataRequest);
                $data['ojtBookmark'] = $ojtBookmark;
                $status = ApiResponseStatusEnums::CREATED;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Toggle OJT bookmark successfully!',
            'status' => $status->value
        ]);
    }

    public function ojtApply(Request $request)
    {
        $dataRequest = $request->all();
        $dataRequest['trainee_id'] = Auth::guard('sanctum')->user()->id;
        $status = ApiResponseStatusEnums::CREATED;
        $applied = OjtTraineeApply::where('trainee_id', Auth::guard('sanctum')->user()->id)->where('ojt_id', $dataRequest['ojt_id'])->first();
        if ($applied) {
            $applied->delete();
            $data['type'] = ApplyTypeEnums::UNAPPLY;
            $status = ApiResponseStatusEnums::OK;
        } else {
            $dataRequest['apply_time'] = date('Y-m-d H:i:s');
            $dataRequest['apply_type'] = 'apply';
            Db::beginTransaction();
            try {
                $ojtApply = OjtTraineeApply::create($dataRequest);
                $data['ojtApply'] = $ojtApply;
                $data['type'] = ApplyTypeEnums::APPLY;
                $status = ApiResponseStatusEnums::CREATED;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Change OJT apply type successfully!',
            'status' => $status->value
        ]);
    }

    public function getOJTCandidate(Request $request, $id)
    {
        $ojt = OJT::where('id', $id)->first();
        $query = $ojt->applies();
        if ($request->has('search') && $request->query('search') != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $searchTerm = '%' . $request->query('search') . '%';
                $q->where(function ($query) use ($searchTerm) {
                    $query
                        ->where('first_name', 'ILIKE', $searchTerm)
                        ->orWhere('last_name', 'ILIKE', $searchTerm)
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
                });
            });
        }
        $status = ApiResponseStatusEnums::OK;
        $applies = $query->paginate(10);
        $data['applies'] = $applies;
        return response()->json([
            'ojt' => $ojt,
            'data' => $data,
            'message' => 'Get candidate list successfully!',
            'status' => $status->value
        ]);
    }

    /**
     * API Get job post list
     * @param Request $request
     * @return JsonResponse
     */
    public function getJobPostList(Request $request): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $jobs = $this->traineeJobService->getJobList($request);
        foreach ($jobs as $job) {
//            $job->job_type = getCodeNameByCodeId('job_type', $job->job_type);
//            $job->gender = is_array($job->gender) ? null : getCodeNameByCodeId('gender', (int) $job->gender);
//            $job->job_location = getCodeNameByCodeId('job_location', $job->job_location);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $jobs->total(),
                'data' => $jobs,
            ],
            'message' => '',
            'status' => $status->value
        ]);
    }

    /**
     * API Get job detail
     * @param Request $request
     * @return JsonResponse
     */
    public function getJobDetail(Request $request): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $job = $this->jobVacancyService->getJobVacancyById($request->query('id'),$request);
//        $job->gender = is_array($job->gender) ? null : getCodeNameByCodeId('gender', (int) $job->gender);
//        $job->job_type = getCodeNameByCodeId('job_type', $job->job_type);
//        $job->job_location = getCodeNameByCodeId('job_location', $job->job_location);
        $job->company_logo = filter_var($job->company_logo, FILTER_VALIDATE_URL) ? $job->company_logo : (file_exists($job->company_logo) ? asset($job->company_logo) : '');
        if (!empty($job->getAttribute('attachments')) && is_array($job->getAttribute('attachments'))) {
            $attachments = [];

            foreach ($job->getAttribute('attachments') as $attachment) {
                $attachments[] = [
                    'file_name' => $attachment,
                    'link' => route('company.job-support.job-vacancy.download-attachment', [
                        'job_id' => $job->id,
                        'filename' => $attachment,
                    ]),
                ];
            }

            $job->setAttribute('attachments', $attachments); // Use setter method
        }

        return response()->json([
            'success' => true,
            'data' => $job,
            'message' => '',
            'status' => $status->value
        ]);
    }

    /**
     * API Trainee apply job
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleApplyJob(Request $request): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $statusApply = $this->traineeAppliesService->toggleApply($request);
        if ($statusApply == 'apply') {
            $message = 'You have apply this job!';
        } else if ($statusApply == 'unapply') {
            $message = 'You have unapply this job!';
        } else if ($statusApply == 'cancel') {
            $message = "Job closed, can't apply!";
        } else {
            $message = 'Error! Something went wrong!';
            // TODO: Log error
            $statusApply = false;
        }
        return response()->json([
            'success' => true,
            'data' => [
                'status_apply' => $statusApply
            ],
            'message' => $message,
            'status' => $status->value
        ]);
    }

    /**
     * API Toggle job bookmark
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleJobBookmark(Request $request): JsonResponse
    {
        $request['trainee_id'] = $request->user()->id;
        $status = $this->jobBookmarkService->mark($request);
        $success = false;
        $code = 200;
        if ($status == 'unmark') {
            $success = true;
            $message = 'You have unmarked this job!';
        } else if ($status == 'mark') {
            $success = true;
            $message = 'You have marked this job!';
        } else {
            $code = 500;
            $message = 'Error! Something went wrong!';
        }
        return response()->json([
            'success' => $success,
            'data' => [
                'status_bookmark' => $status
            ],
            'message' => $message,
            'status' => $code
        ], $code);
    }
}
