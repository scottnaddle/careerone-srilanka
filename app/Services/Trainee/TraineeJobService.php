<?php

namespace App\Services\Trainee;

use App\Enums\JobStatusEnum;
use App\Enums\TypeTraineeApply;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\OJT;
use App\Models\Sector;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TraineeJobService
{
    protected object $model;
    protected object $sectorModel;

    /**
     * TraineeJobService constructor.
     * @param Job $model
     */
    public function __construct(Job $model, Sector $sector)
    {
        $this->model = $model;
        $this->sectorModel = $sector;
    }

    /**
     *
     * @param Request $request
     * @return mixed
     */
    public function getJobList(Request $request): mixed
    {
        $jobs = $this->model::query();
        $trainee = $request->bearerToken() ? auth('sanctum')->user() : \Auth::guard('trainee')->user();
        $traineeId = $trainee?->id;
    
        // Nếu không có status_job thì mặc định lọc theo status PROGRESS
        if (!$request->filled('status_job')) {
            $jobs->where('status', JobStatusEnum::PROGRESS->value);
        }
    
        // Lọc theo title
        if ($title = $request->query('title')) {
            $jobs->where('title', 'ILIKE', "%$title%");
        }
    
        // Lọc theo trạng thái job (applied hoặc matched)
        if ($statusJob = $request->query('status_job')) {
            match ($statusJob) {
                'applied' => $jobs->whereIn('jobs.id', function ($q) use ($traineeId) {
                    $q->select('job_id')->from('trainee_applies')
                        ->where('trainee_id', $traineeId)
                        ->where('apply_type', 'apply');
                }),
                'matched' => $jobs->whereIn('jobs.id', function ($q) use ($traineeId) {
                    $q->select('job_id')->from('trainee_matches')
                        ->where('trainee_id', $traineeId);
                }),
                default => $jobs->where('status', 1)
            };
        } else {
            $jobs->where('status', 1);
        }
    
        // Lọc theo status
        if ($request->filled('status')) {
            $jobs->where('status', $request->query('status'));
        }
    
        // Lọc theo province và district
        if ($request->filled('province')) {
            $jobs->whereHas('company.district', function ($query) use ($request) {
                $query->where('prov_id', $request->query('province'));
                if ($request->filled('district')) {
                    $query->where('id', $request->query('district'));
                }
            });
        }
    
        // Lọc theo sector
        if ($request->filled('sector')) {
            $jobs->where('jobs.sector_id', $request->query('sector'));
        }
    
        // Lọc theo trạng thái bookmark
        if ($request->filled('bookmark') && $request->query('bookmark') !== 'all') {
            $jobs->where(function ($subQuery) use ($request, $traineeId) {
                if ($request->query('bookmark') === 'mark') {
                    $subQuery->whereHas('bookmarks', fn($q) => $q->where('trainee_id', $traineeId));
                } else {
                    $subQuery->whereDoesntHave('bookmarks', fn($q) => $q->where('trainee_id', $traineeId));
                }
            });
        }
    
        // JOIN và SELECT thêm các trường bổ sung
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
    
        // Thêm các trường phụ là is_bookmark, is_apply nếu có trainee
        if ($traineeId) {
            $jobs->selectSub(function ($query) use ($traineeId) {
                $query->from('job_bookmarks')
                    ->selectRaw('CASE WHEN count(1) > 0 THEN true ELSE false END')
                    ->whereColumn('job_bookmarks.job_id', 'jobs.id')
                    ->where('job_bookmarks.trainee_id', $traineeId);
            }, 'is_bookmark');
    
            $jobs->selectSub(function ($query) use ($traineeId) {
                $query->from('trainee_applies')
                    ->selectRaw('CASE WHEN count(1) > 0 THEN true ELSE false END')
                    ->whereColumn('trainee_applies.job_id', 'jobs.id')
                    ->where('apply_type', TypeTraineeApply::APPLY->value)
                    ->where('trainee_id', $traineeId);
            }, 'is_apply');
        }
    
        // Sort
        $jobs->orderBy('created_at', $request->query('sort_by', 'desc'));
    
        // Paginate
        $jobs = $jobs->paginate(10)->appends($request->query());
    
        // Format lại logo
        foreach ($jobs as $job) {
            $job->company_logo = filter_var($job->company_logo, FILTER_VALIDATE_URL)
                ? $job->company_logo
                : (file_exists($job->company_logo) ? asset($job->company_logo) : '');
        }
    
        return $jobs;
    }
    
    public function getOJTList(Request $request): mixed
    {
        $ojts = OJT::query();
        $trainee = $request->bearerToken() ? auth('sanctum')->user() : \Auth::guard('trainee')->user();
        $traineeId = $trainee?->id;
        if (!$request->filled('status_ojt')) {
            $ojts->where('status', JobStatusEnum::PROGRESS->value);
        }
        if ($title = $request->query('title')) {
            $ojts->where('title', 'ILIKE', "%$title%");
        }
        if ($statusJob = $request->query('status_ojt')) {
            match ($statusJob) {
                'applied' => $ojts->whereIn('o_j_t_s.id', function ($q) use ($traineeId) {
                    $q->select('ojt_id')->from('ojt_trainee_applies')
                        ->where('trainee_id', $traineeId)
                        ->where('apply_type', \App\Enums\TypeTraineeApply::APPLY);
                }),
                'matched' => $ojts->whereIn('o_j_t_s.id', function ($q) use ($traineeId) {
                    $q->select('ojt_id')->from('ojt_trainee_applies')
                        ->where('trainee_id', $traineeId)
                        ->where('apply_type', \App\Enums\TypeTraineeApply::OJT_MATCH);
                }),
                default => $ojts->where('status', 1)
            };
        } else {
            $ojts->where('status', 1);
        }
        if ($request->filled('status')) {
            $ojts->where('status', $request->query('status'));
        }
        if ($request->filled('province')) {
            $ojts->whereHas('company.district', function ($query) use ($request) {
                $query->where('prov_id', $request->query('province'));
                if ($request->filled('district')) {
                    $query->where('id', $request->query('district'));
                }
            });
        }
    
        $ojts->select('o_j_t_s.*')
            ->addSelect([
                'companies.name as company_name',
                'companies.logo as company_logo',
                'company_recruiters.first_name as creator_first_name',
                'company_recruiters.last_name as creator_last_name',
            ])
            ->join('companies', 'companies.id', '=', 'o_j_t_s.company_id')
            ->join('company_recruiters', 'company_recruiters.id', '=', 'o_j_t_s.created_by');
    
        $ojts->orderBy('created_at', $request->query('sort_by', 'desc'));
    
        $ojts = $ojts->paginate(10)->appends($request->query());
    
        foreach ($ojts as $job) {
            $job->company_logo = filter_var($job->company_logo, FILTER_VALIDATE_URL)
                ? $job->company_logo
                : (file_exists($job->company_logo) ? asset($job->company_logo) : '');
        }
    
        return $ojts;
    }
    public function getJobDetail(Request $request, $job_id): mixed
    {
        $job = $this->model->find($job_id);
        if ($job == null) {
            return null;
        }
        return $job;
    }
    public function getSectorAndSubSectorById($sectorId, $sub = null)
    {
        if ($sectorId == null) {
            return [null, null];
        }
        $sectors = $this->sectorModel->find($sectorId);
        //TODO: sub sector
        return [$sectors, null];
    }

    /**
     * @return array
     */
    public function getSector(): array
    {
        $sectors = $this->sectorModel->get();

        return [
            'data' => $sectors,
            'total' => count($sectors),
        ];
    }
}
