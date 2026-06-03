<?php

namespace App\Filament\Resources\Information\NoiticeResource\Pages;

use App\Filament\Resources\Information\NoiticeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNoitice extends EditRecord
{
    protected static string $resource = NoiticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
