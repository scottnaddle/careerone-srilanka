<?php

namespace App\Filament\Resources\SchoolKidResource\Pages;

use App\Filament\Resources\SchoolKidResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolKid extends ViewRecord
{
    protected static string $resource = SchoolKidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
