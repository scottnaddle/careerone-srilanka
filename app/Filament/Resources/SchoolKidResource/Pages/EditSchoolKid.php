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
        // Only hash password if it's changed (not empty)
        if (isset($data['password']) && filled($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
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
