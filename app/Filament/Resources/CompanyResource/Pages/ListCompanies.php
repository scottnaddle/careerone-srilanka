<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Sector;
use App\Models\District;
use App\Models\Company;


class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;
    protected static string $view = 'filament.pages.membership.company.company-list';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getSector()
    {
        return Sector::get();
    }
    protected function getDistrict()
    {
        return District::get();
    }
    protected function getCompany()
    {
        return Company::get();
    }
    protected function getTotal()
    {
        return CompanyResource::$totalCompany;
    }
}
