<?php

namespace App\Filament\Resources\CompanyJobResource\Pages;

use App\Filament\Resources\CompanyJobResource;
use App\Models\Company;
use App\Models\Job;
use App\Services\Admin\CompanyJobService;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewJobCandidate extends ViewRecord
{
    protected static string $resource = CompanyJobResource::class;
    protected static string $view = 'filament.pages.job-support.company-job.view-job-candidate';
    public $job;

    public function mount($record): void
    {
        parent::mount($record);
        $this->loadJob(request()->route('job'));
    }

    /**
     * Load the job based on the job ID.
     *
     * @param int|string|null $jobId
     */
    protected function loadJob($jobId)
    {
        if (!$jobId) {
            return;
        }
    
        $this->job = $this->record->jobs()->findOrFail($jobId);
        $search = strtolower(request('search', ''));
        $searchTerms = $search ? explode(' ', $search) : [];
        $searchTime = request('search-time', 'desc');
        $status = request('status');
        $applies = $this->job->applies()
            ->select([
                DB::raw('MAX(id) as id'),
                'trainee_id',
                DB::raw('MAX(job_id) as job_id'),
                DB::raw('MAX(apply_time) as apply_time'),
                DB::raw('MAX(read) as read'),
                DB::raw('MAX(selected) as selected'),
                DB::raw('MAX(employeed) as employeed'),
                DB::raw('STRING_AGG(apply_type, \',\') as apply_types'),
                DB::raw('MAX(created_at) as latest_apply_date'),
                DB::raw('MAX(updated_at) as updated_at')
            ])
            ->groupBy('trainee_id');
    
        // Nếu có từ khóa tìm kiếm
        if (!empty($searchTerms)) {
            $applies->whereHas('user', function ($query) use ($searchTerms) {
                $query->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->orWhereRaw('LOWER(first_name) LIKE ?', ["%$term%"])
                              ->orWhereRaw('LOWER(last_name) LIKE ?', ["%$term%"])
                              ->orWhereRaw('LOWER(full_name) LIKE ?', ["%$term%"]);
                    }
                });
            });
        }
    
        // Sắp xếp theo thời gian apply
        $applies->orderBy('latest_apply_date', $searchTime === 'asc' ? 'ASC' : 'DESC');
    
        // Lọc theo status nếu có
        $statusFilters = [
            'read' => 'read',
            'selected' => 'selected',
            'employeed' => 'employeed'
        ];
    
        if (!empty($status)) {
            $applies->where('status', '', $status);
        }
    
        // Lấy kết quả và xử lý apply_types
        $results = $applies->paginate(10);
    
        foreach ($results as $result) {
            $result->apply_types = explode(',', $result->apply_types);
        }
    
        $this->job->appliesTypeApply = $results;
    }
    

    protected function getViewData(): array
    {
        return [
            'company' => $this->record,
            'job' => $this->job,
        ];
    }
}
