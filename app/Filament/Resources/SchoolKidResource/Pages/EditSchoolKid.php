<?php

namespace App\Filament\Resources\SchoolKidResource\Pages;

use App\Filament\Resources\SchoolKidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolKid extends EditRecord
{
    protected static string $resource = SchoolKidResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Password is auto-hashed by SchoolKid::setPasswordAttribute mutator.
        // Only unset if empty so the model doesn't re-hash an empty string.
        if (!isset($data['password']) || !filled($data['password'])) {
            unset($data['password']);
        }
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
