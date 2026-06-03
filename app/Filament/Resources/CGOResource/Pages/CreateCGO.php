<?php

namespace App\Filament\Resources\CGOResource\Pages;

use App\Filament\Resources\CGOResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCGO extends CreateRecord
{
    protected static string $resource = CGOResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
