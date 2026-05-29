<?php

namespace App\Filament\Resources\Api\PackagesResource\Pages;

use App\Filament\Resources\Api\PackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPackages extends ViewRecord
{
    protected static string $resource = PackagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
