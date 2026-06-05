<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class ViewCandidateJobs extends ViewRecord
{
    protected static string $resource = JobResource::class;
    protected static string $view = 'filament.pages.job-support.job-candidate';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
    public $jobData;

    public function mount($record): void
    {
        parent::mount($record);
        $this->record->load('sector', 'company', 'district', 'appliesTypeMatch', 'appliesTypeApply');
        $this->jobData = $this->record;
        $job = Job::find($record);

        $applies = $job->applies()
            ->select(
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
            )
            ->groupBy('trainee_id');

        if (request()->has('search') && !empty(request()->query('search'))) {
            $searchTerm = strtolower(request()->query('search'));
            $searchTerms = explode(' ', $searchTerm);

            $applies->whereHas('user', function($query) use ($searchTerms) {
                $query->where(function($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->whereRaw('LOWER(first_name) LIKE ?', ['%' . $term . '%'])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . $term . '%'])
                            ->orWhereRaw('LOWER(full_name) ILIKE ?', ['%' . $term . '%']);
                    }
                });
            });
        }

        if (request()->has('status') && !empty(request()->query('status'))) {
            if (request()->query('status') == 'read') {
                $applies->where('read', '!=', null);
            } else if (request()->query('status') == 'selected') {
                $applies->where('selected', '!=', null);
            } else if (request()->query('status') == 'employeed') {
                $applies->where('employeed', '!=', null);
            }
        }

        $applies->orderBy('latest_apply_date', 'desc');

        $results = $applies->paginate(10);

        foreach ($results as $result) {
            $result->apply_types = explode(',', $result->apply_types);
        }

        $this->jobData->appliesTypeApply = $results;
    }


}
