<?php

namespace App\Filament\Resources\CompanyRecruiterApprovalResource\Pages;

use App\Filament\Resources\CompanyRecruiterApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyRecruiterApprovals extends ListRecords
{
    protected static string $resource = CompanyRecruiterApprovalResource::class;
    protected static ?string $breadcrumb = 'Company Recruiter Approval List';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
