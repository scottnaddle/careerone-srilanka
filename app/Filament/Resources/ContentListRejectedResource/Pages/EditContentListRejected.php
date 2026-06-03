<?php

namespace App\Filament\Resources\ContentListRejectedResource\Pages;

use App\Filament\Resources\ContentListRejectedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentListRejected extends EditRecord
{
    protected static string $resource = ContentListRejectedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
