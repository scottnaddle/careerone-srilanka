<?php

namespace App\Filament\Resources\JobCompanyResource\Pages;

use App\Filament\Resources\JobCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobCompany extends EditRecord
{
    protected static string $resource = JobCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
