<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Enums\WorkingDayEnum;
use App\Filament\Resources\JobResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use App\Models\AdminUser;
use App\Models\District;
use App\Models\Sector;
use Filament\Forms\Components\View;

class ViewJobs extends ViewRecord
{
    protected static string $resource = JobResource::class;
    protected static string $view = 'filament.pages.job-support.view-job';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public $jobData;

    public function mount($record): void
    {
        parent::mount($record);
        $this->record->load('sector', 'company', 'district');
        $this->jobData = $this->record;

        $this->working_day = WorkingDayEnum::getAllDay();
//        $job->creator_first_name = $job->companyRecruiter->first_name;
//        $job->creator_last_name = $job->companyRecruiter->last_name;
//        $this->jobData->working_day =  $this->jobData->working_day ? explode(',',  $this->jobData->working_day) : [];
        $this->jobData->start_date = $this->jobData->start_date ? Carbon::parse($this->jobData->start_date)->format('Y-m-d') : '';
        $this->jobData->application_starttime = $this->jobData->application_starttime ? Carbon::parse($this->jobData->application_starttime)->format('Y-m-d') : null;
        $this->jobData->application_endtime = $this->jobData->application_endtime ? Carbon::parse($this->jobData->application_endtime)->format('Y-m-d') : null;
        $this->jobData->company_name = $this->jobData->company->name;
        $this->jobData->sector_name = $this->jobData->sector->name;
        $attachmentsPath = storage_path('app/public/company/job_vacancy_attachments/' . $this->jobData->id);
        $attachments = [];

        if (file_exists($attachmentsPath) && is_dir($attachmentsPath)) {
            $files = glob($attachmentsPath . '/*');
            foreach ($files as $file) {
                $attachments[] = basename($file);
            }
        }
        $this->jobData->attachments = $attachments;
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
