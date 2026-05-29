<?php

namespace App\Filament\Resources\CGOResource\Pages;

use App\Filament\Resources\CGOResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCGO extends EditRecord
{
    protected static string $resource = CGOResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
