<?php

namespace App\Filament\Resources\Api\InstituteResource\Pages;

use App\Filament\Resources\Api\InstituteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstitute extends EditRecord
{
    protected static string $resource = InstituteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
