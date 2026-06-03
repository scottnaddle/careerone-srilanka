<?php

namespace App\Filament\Resources\Information\EventListRejectedResource\Pages;

use App\Filament\Resources\Information\EventListRejectedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventListRejected extends EditRecord
{
    protected static string $resource = EventListRejectedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
