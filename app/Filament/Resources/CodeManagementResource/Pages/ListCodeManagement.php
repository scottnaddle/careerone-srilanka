<?php

namespace App\Filament\Resources\CodeManagementResource\Pages;

use App\Filament\Resources\CodeManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCodeManagement extends ListRecords
{
    protected static string $resource = CodeManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
