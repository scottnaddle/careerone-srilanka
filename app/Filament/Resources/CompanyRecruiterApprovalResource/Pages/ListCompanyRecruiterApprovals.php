<?php

namespace App\Filament\Resources\CompanyRecruiterApprovalResource\Pages;

use App\Filament\Resources\CompanyRecruiterApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyRecruiterApprovals extends ListRecords
{
    protected static string $resource = CompanyRecruiterApprovalResource::class;
//    public function getBreadcrumb(): string
//    {
//        return trans('admin/performance.Company Recruiters Approval List');
//    }
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
