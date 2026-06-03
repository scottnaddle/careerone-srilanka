<?php

namespace App\Filament\Resources\PopupResource\Pages;

use App\Filament\Resources\PopupResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePopup extends CreateRecord
{
    protected static string $resource = PopupResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return PopupResource::getUrl('index');
    }
}
