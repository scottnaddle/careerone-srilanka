<?php

namespace App\Filament\Resources\SchoolKidResource\Pages;

use App\Filament\Resources\SchoolKidResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolKid extends CreateRecord
{
    protected static string $resource = SchoolKidResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Password is auto-hashed by SchoolKid::setPasswordAttribute mutator
        return $data;
    }
}
