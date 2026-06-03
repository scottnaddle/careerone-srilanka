<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Sector;
use App\Models\District;
use App\Models\Company;
use Filament\Actions\CreateAction;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;
    protected static string $view = 'filament.pages.membership.company.company-list';
    protected static ?string $breadcrumb = '';
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
    public function getCreateAction(): ?CreateAction
    {
        // Kiểm tra quyền trước khi hiển thị nút
        if (!CompanyResource::canCreate()) {
            return null;
        }

        return CreateAction::make()
            ->label('Add New Company')
            ->icon('heroicon-o-plus')
            ->color('primary')
            ->url(CompanyResource::getUrl('create'));
    }
}
