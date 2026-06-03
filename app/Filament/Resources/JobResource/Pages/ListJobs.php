<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use App\Models\District;
use App\Models\Sector;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ListRecords;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;

class ListJobs extends ListRecords
{
    protected static string $resource = JobResource::class;

    protected static string $view = 'filament.pages.job-support.job-list';
    protected static ?string $title = '';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            // Actions\CreateAction::make(),
        ];
    }

    public function dateRangePicker() {
        return DateRangePicker::make('created_at')->startDate(Carbon::now())->endDate(Carbon::now());
    }

    // Corrected method signature to allow query filtering
    protected function getSectors()
    {
        return Sector::get();
    }
    protected function getDistricts()
    {
        return District::get();
    }
    protected function getTotalResults() {
        return JobResource::$totalResults;
    }
}
