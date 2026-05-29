<?php

namespace App\Filament\Resources\CounselingListResource\Pages;

use App\Filament\Resources\CounselingListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCounselingList extends EditRecord
{
    protected static string $resource = CounselingListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
