<?php

namespace App\Filament\Resources\Information\NoiticeResource\Pages;

use App\Filament\Resources\Information\NoiticeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNoitice extends CreateRecord
{
    protected static string $resource = NoiticeResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return NoiticeResource::getUrl('index');
    }
}
