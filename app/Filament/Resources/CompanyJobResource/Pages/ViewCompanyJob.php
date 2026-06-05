<?php

namespace App\Filament\Resources\CompanyJobResource\Pages;

use App\Filament\Resources\CompanyJobResource;
use App\Models\Company;
use App\Models\District;
use App\Models\Job;
use App\Models\Sector;
use App\Services\Admin\CompanyJobService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\JobStatusEnum;
class ViewCompanyJob extends ViewRecord
{
    protected static string $resource = CompanyJobResource::class;
    protected static ?string $title = 'Job Posting';
    public CompanyJobService $companyJobService;
    protected static string $view = 'filament.pages.job-support.company-job.view-company-job';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public $company;
    public $jobStatuses=[];
    public function mount($record): void
    {
        parent::mount($record);
        $this->record->load('jobs');
        $this->company = $this->record;
        $companyQuery = Company::find($record);
        $status=request()->query('status');
        $jobs = $companyQuery->jobs();
        if (request()->has('title') && !empty(request()->query('title'))) {
            $searchTerm = strtolower(request()->query('title'));
            $jobs->where('title', 'ILIKE', '%' . $searchTerm . '%');
        }

        if (request()->has('search-time') && !empty(request()->query('search-time'))) {
            if (request()->query('search-time') == 'oldest') {
                $jobs->orderBy('created_at', 'asc');
            } else {
                $jobs->orderBy('created_at', 'desc');
            }
        }
        if (request()->has('status') && request()->query('status') !== null) {
            $status = request()->query('status');
            $jobs->where('status', '=', $status);
        }

        $this->jobStatuses = JobStatusEnum::getAllStatus();
        $results = $jobs->paginate(10);

        $this->company->jobs = $results;
    }

}
