<?php

namespace App\Filament\Resources\NewsletterCategoryResource\Pages;

use App\Filament\Resources\NewsletterCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterCategory extends CreateRecord
{
    protected static string $resource = NewsletterCategoryResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
