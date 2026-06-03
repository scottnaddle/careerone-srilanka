<?php

namespace App\Filament\Resources\Api\InstituteResource\Pages;

use App\Filament\Resources\Api\InstituteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInstitute extends ViewRecord
{
    protected static string $resource = InstituteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
