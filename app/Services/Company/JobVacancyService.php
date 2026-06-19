<?php

namespace App\Services\Company;

use App\Jobs\SendJobRegistrationNotificationSendCGOJob;
use App\Models\Job;
use App\Models\QnaAttachment;
use App\Services\Trainee\TraineeAppliesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\Trainee\NotificationManager;
class JobVacancyService
{
	protected object $model;

	/**
	 * JobVacancyService constructor.
	 * @param Job $model
	 */
	protected $notificationManager;
    protected TraineeAppliesService $traineeAppliesService;
	public function __construct(Job $model,NotificationManager $notificationManager, TraineeAppliesService $traineeAppliesService)
	{
		$this->model = $model;
		$this->notificationManager = $notificationManager;
        $this->traineeAppliesService = $traineeAppliesService;
	}

	/**
	 * Create job vacancy
	 *
	 * @param $request array request data from controller to store job vacancy
	 * @return mixed
	 */
	public function storeJobVacancy(array $request): mixed
	{
		$data = $this->setupData($request);
		$data['company_id'] = auth()->guard('company')->user()->company_id;
		$data['status'] = 1;
		$data['slug'] = Str::slug($request['title'], '-', 'ta');
		$data['created_by'] = auth()->guard('company')->user()->id;
		// Handle gender
		$data['gender'] = $request['gender'] ? json_encode($request['gender']) : json_encode([]);
		$job_vacancy = $this->model->create($data);

		if (isset($request['attach_file']) && !empty($request['attach_file'] && $job_vacancy)) {
			$storage_path = storage_path('app/public/company/job_vacancy_attachments/' . $job_vacancy->id);
			foreach ($request['attach_file'] as $file) {

				$filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$extension = $file->getClientOriginalExtension();
				$fileNameToStore = $filename . '.' . $extension;
				$file->move($storage_path, $fileNameToStore);
			}
		}
		SendJobRegistrationNotificationSendCGOJob::dispatch($job_vacancy->slug);
		return $job_vacancy;
	}
	private function setupData($request)
	{
		return array(
			'title' => $request['title'],
			'job_type' => $request['job_type'],
			'job_location' => $request['job_location'],
			'sector_id' => $request['sector_id'],
			'work_type' => $request['work_type'],
			//			'working_day' => implode(",", $request['working_day'] ?? []),
			'working_day' => $request['working_day'],
			'start_date' => $request['start_date'] ? Carbon::parse($request['start_date'])->format('Y-m-d') : null,
			'start_time' => $request['start_time'],
			'end_time' => $request['end_time'],
			'min_salary' => $request['min_salary'],
			'salary_currency' => $request['salary_currency'],
			'max_salary' => $request['max_salary'] ?? null,
			'discussion_salary' => filter_var($request['discussion_salary'], FILTER_VALIDATE_BOOLEAN),
			'gender' => $request['gender'],
			'min_age' => isset($request['min_age']) ? $request['min_age'] : null,
			'max_age' => isset($request['max_age']) ? $request['max_age'] : null,
			'not_limit_age' => !empty($request['not_limit_age']) ? filter_var($request['not_limit_age'], FILTER_VALIDATE_BOOLEAN) : false,
			'min_work_experience' => $request['min_work_experience'] ?? null,
			'not_limit_experience' => filter_var($request['not_limit_experience'], FILTER_VALIDATE_BOOLEAN),
			'nvq_level' => $request['nvq_level'],
			'required_skills' => $request['required_skills'],
			'application_starttime' => $request['application_starttime'] ? Carbon::parse($request['application_starttime'])->format('Y-m-d') : null,
			'application_endtime' => $request['application_endtime'] ? Carbon::parse($request['application_endtime'])->format('Y-m-d') : null,
			// 'slug' => Str::slug($request['title']),
			'hr_name' => $request['hr_name'],
			'hr_email' => $request['hr_email'],
			'hr_contact_info' => $request['hr_contact_info'],
			'roles' => $request['roles'],
			'number_of_recruitments' => $request['number_of_recruitments'],
            'sector_information' => $request['sector_information'],
            'salary_type' => $request['salary_type'],
		);
	}

	/**
	 * Get job vacancy list by company id
	 *
	 * @param $status int|null status of job vacancy
	 * @return mixed
	 */
	public function getJobVacancyListByCompanyId(Request $request, $company_id): mixed
	{
		$this->model->where('company_id', $company_id);

		$jobs = $this->model->query()->where('company_id', $company_id);

		if ($request->has('search') && !empty($request->query('search'))) {
			$jobs->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($request->query('search')) . '%']);
		}

		if ($request->has('status') && $request->query('status') != '') {
			$jobs->where('status', $request->query('status'));
		}
		if ($request->has('sort_by') && $request->query('sort_by') != '') {
			$jobs->orderBy('created_at',  $request->query('sort_by'));
		} else {
			$jobs->orderBy('created_at', 'desc');
		}

		return $jobs->paginate(10)->appends($request->query());
	}

	/**
	 * Get job vacancy by id
	 *
	 * @param $job_id
	 * @return mixed
	 */
	public function getJobVacancyById($job_id, $request = null)
	{
		$job = $this->model->find($job_id);
		if (!empty($request)) {
            $id_user = null;
			if ($request->bearerToken()) {
				$id_user = auth('sanctum')->user()->id;
			}
            if (auth()->guard('trainee')->check()) {
                $id_user = auth()->guard('trainee')->user()->id;
            }
		}
		if ($job) {
			$job->creator_first_name = $job->companyRecruiter->first_name;
			$job->creator_last_name = $job->companyRecruiter->last_name;
			//			$job->working_day = $job->working_day ? explode(',', $job->working_day) : [];
			$job->start_date = $job->start_date ? Carbon::parse($job->start_date)->format('Y-m-d') : '';
			$job->application_starttime = $job->application_starttime ? Carbon::parse($job->application_starttime)->format('Y-m-d') : null;
			$job->application_endtime = $job->application_endtime ? Carbon::parse($job->application_endtime)->format('Y-m-d') : null;
			$job->company_name = $job->company->name;
			$job->sector_name = $job->sector->name;
            if (!empty($request)) {
                $job->is_apply    = $job->isApplyByTrainee($id_user) ? true : false;
                $job->is_matched  = $job->isMatchedByCgo($id_user) ? true : false;
                $job->is_bookmark = $job->isMarkByTrainee($id_user) ? true : false;

                $status = null;

                if ($job->is_apply) {
                    $apply = $this->traineeAppliesService->getTraineeApplyByJobId($job_id);

                    if ($apply) {
                        if ($apply->employeed) {
                            $status = 'Employeed';
                        } elseif ($apply->selected) {
                            $status = 'Selected';
                        } else {
                            $status = 'Applied';
                        }
                    }
                }

                if ($job->is_matched && !$status) { // only assign if there is no status yet
                    $matched = $this->traineeAppliesService->getTraineeMatchedByJobId($job_id);

                    if ($matched) {
                        if ($matched->employeed) {
                            $status = 'Employeed';
                        } elseif ($matched->selected) {
                            $status = 'Selected';
                        } else {
                            $status = 'Matched';
                        }
                    }
                }

                $job->statusApply = $status;
            }

			$attachmentsPath = storage_path('app/public/company/job_vacancy_attachments/' . $job->id);
			$attachments = [];

			if (file_exists($attachmentsPath) && is_dir($attachmentsPath)) {
				$files = glob($attachmentsPath . '/*');
				foreach ($files as $file) {
					$attachments[] = basename($file);
				}
			}
			$job->attachments = $attachments;
		}
		return $job;
	}

	/**
	 * Update job vacancy
	 *
	 * @param $request
	 * @param $job_id
	 * @return mixed
	 */
	public function updateJobVacancy($request, $job_id)
	{
		$job_vacancy = $this->model->find($job_id);

		$data = $this->setupData($request);
		$data['status'] = $request['status'] ?? 1;
		// Handle gender
		$data['gender'] = $request['gender'] ? json_encode($request['gender']) : json_encode([]);
		if ($job_vacancy) {
			$job_vacancy->update($data);
		}

		if (isset($request['files_deleted']) && !empty($request['files_deleted'] && $job_vacancy)) {
			$filenames = explode(";", $request['files_deleted']);
			foreach ($filenames as $filename) {
				$attachmentsPath = storage_path('app/public/company/job_vacancy_attachments/' . $job_vacancy->id . '/' . $filename);
				if (file_exists($attachmentsPath)) {
					File::delete($attachmentsPath);
				}
			}
		}
		if (isset($request['attach_file']) && !empty($request['attach_file'] && $job_vacancy)) {
			$storage_path = storage_path('app/public/company/job_vacancy_attachments/' . $job_vacancy->id);
			foreach ($request['attach_file'] as $file) {

				$filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$extension = $file->getClientOriginalExtension();
				$fileNameToStore = $filename . '.' . $extension;
				$file->move($storage_path, $fileNameToStore);
			}
		}

		return $job_vacancy;
	}

	/**
	 * Delete job vacancy
	 *
	 * @param $job_id
	 * @return bool
	 */
	public function deleteJobVacancy($job_id)
	{
		$job_vacancy = $this->model->find($job_id);
		//		if ($job_vacancy->applies()->count() > 0 || $job_vacancy->matches()->count() > 0) {
		//			return false;
		//		}
		if ($job_vacancy) {
			$attachmentsPath = storage_path('app/public/company/job_vacancy_attachments/' . $job_vacancy->id);

			if (file_exists($attachmentsPath) && is_dir($attachmentsPath)) {
				File::deleteDirectory($attachmentsPath);
			}
			return $job_vacancy->delete();
		}
		return false;
	}

	/**
	 * @param Request $request
	 * @param $job_id
	 * @return mixed
	 */
	public function getTraineeApplyListByJobId(Request $request, $job_id): mixed
	{
		$job = $this->model->find($job_id);

		//        if (!$job || $job->company_id != auth()->guard('company')->user()->company_id) {
		//            return [];
		//        }
		if (!$job) {
			return [];
		}

		$applies = $job->applies()
			->select(
				DB::raw('MAX(id) as id'),
				'trainee_id',
				DB::raw('MAX(job_id) as job_id'),
				DB::raw('MAX(apply_time) as apply_time'),
				DB::raw('MAX(read) as read'),
				DB::raw('MAX(selected) as selected'),
				DB::raw('MAX(employeed) as employeed'),
				DB::raw('STRING_AGG(DISTINCT apply_type, \',\') as apply_types'),
				DB::raw('MAX(created_at) as latest_apply_date'),
				DB::raw('MAX(updated_at) as updated_at')
			)
			->groupBy('trainee_id');

		if ($request->has('name_search') && !empty($request->query('name_search'))) {
			$searchTerm = strtolower($request->query('name_search'));
			$searchTerms = explode(' ', $searchTerm);

			$applies->whereHas('user', function ($query) use ($searchTerms) {
				$query->where(function ($query) use ($searchTerms) {
					foreach ($searchTerms as $term) {
						$query->whereRaw('LOWER(first_name) LIKE ?', ['%' . $term . '%'])
							->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . $term . '%'])
							->orWhereRaw('LOWER(full_name) LIKE ?', ['%' . $term . '%']);
					}
				});
			});
		}

		if ($request->has('status') && !empty($request->query('status'))) {
			if ($request->query('status') == 'read') {
				$applies->where('read', '!=', null);
			} else if ($request->query('status') == 'selected') {
				$applies->where('selected', '!=', null);
			} else if ($request->query('status') == 'employeed') {
				$applies->where('employeed', '!=', null);
			}
		}

		$applies->orderBy('latest_apply_date', 'desc');

		$results = $applies->paginate(10)->appends($request->query());

		foreach ($results as $result) {
			$result->apply_types = explode(',', $result->apply_types);
		}
		return $results;
	}


	/**
	 * Get all trainee apply in company
	 *
	 * @param Request $request
	 * @param $company_id
	 * @return mixed
	 */
//	public function getTraineeApplyListByCompanyId(Request $request, $company_id)
//	{
//		$appliesQuery = \App\Models\TraineeApply::select(
//			DB::raw('MAX(id) as id'),
//			'trainee_id',
//			'job_id',
//			DB::raw('MAX(apply_time) as apply_time'),
//			DB::raw('MAX(read) as read'),
//			DB::raw('MAX(selected) as selected'),
//			DB::raw('MAX(employeed) as employeed'),
//			DB::raw('STRING_AGG(apply_type, \',\') as apply_types'),
//			DB::raw('MAX(created_at) as latest_apply_date'),
//			DB::raw('MAX(updated_at) as updated_at')
//		)
//			->whereHas('job', function ($query) use ($company_id) {
//				$query->where('company_id', $company_id);
//			})
//			->groupBy('trainee_id', 'job_id');
//
//		if ($request->has('name_search') && !empty($request->query('name_search'))) {
//			$searchTerm = strtolower($request->query('name_search'));
//
//			$searchTerms = explode(' ', $searchTerm);
//
//			$appliesQuery->whereHas('user', function ($query) use ($searchTerms) {
//				$query->where(function ($query) use ($searchTerms) {
//					foreach ($searchTerms as $term) {
//						$query->whereRaw('LOWER(first_name) LIKE ?', ['%' . $term . '%'])
//							->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . $term . '%'])
//							->orWhereRaw('LOWER(full_name) LIKE ?', ['%' . $term . '%']);
//					}
//				});
//			});
//		}
//		if ($request->has('status') && !empty($request->query('status'))) {
//			if ($request->query('status') == 'read') {
//				$appliesQuery->where('read', '!=', null);
//			} else if ($request->query('status') == 'selected') {
//				$appliesQuery->where('selected', '!=', null);
//			} else if ($request->query('status') == 'employeed') {
//				$appliesQuery->where('employeed', '!=', null);
//			}
//		}
//		//Add filter by apply type
//		if ($request->has('apply_type') && !empty($request->query('apply_type'))) {
//			$appliesQuery->where('apply_type', $request->apply_type);
//		}
//		$appliesQuery->orderBy('latest_apply_date', 'desc');
//
//		$results = $appliesQuery->paginate(10)->appends($request->query());
//
//		foreach ($results as $result) {
//			$result->apply_types = explode(',', $result->apply_types);
//		}
//		return $results;
//	}
    public function getTraineeApplyListByCompanyId(Request $request, $company_id)
    {
        $appliesQuery = \App\Models\TraineeApply::select(
            'trainee_id',
            'job_id',
            'apply_type',
            DB::raw('MAX(id) as id'),
            DB::raw('MAX(apply_time) as apply_time'),
            DB::raw('MAX(read) as read'),
            DB::raw('MAX(selected) as selected'),
            DB::raw('MAX(employeed) as employeed'),
            DB::raw('MAX(created_at) as latest_apply_date'),
            DB::raw('MAX(updated_at) as updated_at')
        )
            ->whereHas('job', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })
            ->groupBy('trainee_id', 'job_id', 'apply_type');

        // Search filter
        if ($request->filled('name_search')) {
            $searchTerms = explode(' ', strtolower($request->query('name_search')));

            $appliesQuery->whereHas('user', function ($query) use ($searchTerms) {
                $query->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->whereRaw('LOWER(first_name) LIKE ?', ['%' . $term . '%'])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . $term . '%'])
                            ->orWhereRaw('LOWER(full_name) LIKE ?', ['%' . $term . '%']);
                    }
                });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            match ($request->query('status')) {
                'read'      => $appliesQuery->whereNotNull('read'),
                'selected'  => $appliesQuery->whereNotNull('selected'),
                'employeed' => $appliesQuery->whereNotNull('employeed'),
            };
        }

        // Apply type filter
        if ($request->filled('apply_type')) {
            $appliesQuery->where('apply_type', $request->query('apply_type'));
        }

        $appliesQuery->orderByDesc('latest_apply_date');

        $results = $appliesQuery->paginate(10)->appends($request->query());

        return $results;
    }

}
