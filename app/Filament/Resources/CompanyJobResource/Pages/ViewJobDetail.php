<?php

namespace App\Filament\Resources\CompanyJobResource\Pages;

use App\Enums\WorkingDayEnum;
use App\Filament\Resources\CompanyJobResource;
use App\Models\Company;
use App\Models\District;
use App\Models\Job;
use App\Models\Sector;
use App\Services\Admin\CompanyJobService;
use Carbon\Carbon;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewJobDetail extends ViewRecord
{
    protected static string $resource = CompanyJobResource::class;
    protected static string $view = 'filament.pages.job-support.company-job.job-details';
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
        if ($jobId) {
            $this->job = $this->record->jobs()->findOrFail($jobId);

//            $this->working_day = WorkingDayEnum::getAllDay();
//        $job->creator_first_name = $job->companyRecruiter->first_name;
//        $job->creator_last_name = $job->companyRecruiter->last_name;
//            $this->job->working_day =  $this->job->working_day ? explode(',',  $this->job->working_day) : [];
            $this->job->start_date = $this->job->start_date ? Carbon::parse($this->job->start_date)->format('Y-m-d') : '';
            $this->job->application_starttime = $this->job->application_starttime ? Carbon::parse($this->job->application_starttime)->format('Y-m-d') : null;
            $this->job->application_endtime = $this->job->application_endtime ? Carbon::parse($this->job->application_endtime)->format('Y-m-d') : null;
            $this->job->company_name = $this->job->company->name;
            $this->job->sector_name = $this->job->sector->name;
            $attachmentsPath = storage_path('app/public/company/job_vacancy_attachments/' . $this->job->id);
            $attachments = [];

            if (file_exists($attachmentsPath) && is_dir($attachmentsPath)) {
                $files = glob($attachmentsPath . '/*');
                foreach ($files as $file) {
                    $attachments[] = basename($file);
                }
            }
            $this->job->attachments = $attachments;
        }
    }

    protected function getViewData(): array
    {
        return [
            'company' => $this->record,
            'job' => $this->job,
        ];
    }

    protected function getSectors()
    {
        return Sector::get();
    }
    protected function getDistricts()
    {
        return District::get();
    }
}
