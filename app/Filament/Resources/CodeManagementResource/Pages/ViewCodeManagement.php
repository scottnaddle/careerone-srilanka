<?php

namespace App\Filament\Resources\CodeManagementResource\Pages;

use App\Filament\Resources\CodeManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCodeManagement extends ViewRecord
{
    protected static string $resource = CodeManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
