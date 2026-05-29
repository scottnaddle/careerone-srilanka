<?php

namespace App\Filament\Resources\CompanyJobResource\Pages;

use App\Filament\Resources\CompanyJobResource;
use App\Models\District;
use App\Models\Sector;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyJobs extends ListRecords
{
    protected static string $resource = CompanyJobResource::class;
    protected static string $view = 'filament.pages.job-support.company-job.company-job-list';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
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
    protected function getTotalResults() {
        return CompanyJobResource::$totalResults;
    }
}
