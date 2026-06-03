<?php

namespace App\Filament\Resources\OJTResource\Pages;

use App\Filament\Resources\OJTResource;
use App\Models\District;
use App\Models\Sector;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOjts extends ListRecords
{
    protected static string $resource = OJTResource::class;
    protected static ?string $title = 'OJT List';
    protected static string $view = 'filament.pages.job-support.ojt.ojt-list';
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
        return OJTResource::$totalResults;
    }

}
