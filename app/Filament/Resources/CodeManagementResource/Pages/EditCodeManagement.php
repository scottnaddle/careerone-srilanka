<?php

namespace App\Filament\Resources\CodeManagementResource\Pages;

use App\Filament\Resources\CodeManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCodeManagement extends EditRecord
{
    protected static string $resource = CodeManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
