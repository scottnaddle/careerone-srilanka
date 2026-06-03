<?php

namespace App\Filament\Resources\CgoRejectListResource\Pages;

use App\Filament\Resources\CgoRejectListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCgoRejectLists extends ListRecords
{
    protected static string $resource = CgoRejectListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
