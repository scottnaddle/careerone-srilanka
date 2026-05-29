<?php

namespace App\Filament\Resources\CompanyRecruiterApprovalResource\Pages;

use App\Filament\Resources\CompanyRecruiterApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyRecruiterApproval extends EditRecord
{
    protected static string $resource = CompanyRecruiterApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
