<?php

namespace App\Filament\Resources\Information\FAQResource\Pages;

use App\Filament\Resources\Information\FAQResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFAQ extends CreateRecord
{
    protected static string $resource = FAQResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return FAQResource::getUrl('index');
    }
}
