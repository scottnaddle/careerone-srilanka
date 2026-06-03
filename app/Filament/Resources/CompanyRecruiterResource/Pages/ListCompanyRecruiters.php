<?php

namespace App\Filament\Resources\CompanyRecruiterResource\Pages;

use App\Filament\Resources\CompanyRecruiterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyRecruiters extends ListRecords
{
    protected static string $resource = CompanyRecruiterResource::class;
    protected static ?string $breadcrumb = 'Company Recruiter List';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
        ];
    }
}
