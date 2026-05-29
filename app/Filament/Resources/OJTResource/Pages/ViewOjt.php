<?php

namespace App\Filament\Resources\OJTResource\Pages;

use App\Filament\Resources\JobResource;
use App\Filament\Resources\OJTResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Models\District;
use App\Models\Sector;
use App\Models\Company;

class ViewOjt extends ViewRecord
{
    protected static string $resource = OJTResource::class;
    protected static string $view = 'filament.pages.job-support.ojt.ojt-details';
    protected static ?string $title = 'View OJT';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
    public $ojt;

    public function mount($record): void
    {
        parent::mount($record);
        $this->record->load('sector', 'company', 'district');
        $this->ojt = $this->record;
        $this->companyList = Company::whereNotNull('verified_by')->whereNotNull('verified_by')->get();
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
