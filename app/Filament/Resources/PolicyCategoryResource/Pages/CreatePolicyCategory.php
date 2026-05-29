<?php

namespace App\Filament\Resources\PolicyCategoryResource\Pages;

use App\Filament\Resources\PolicyCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePolicyCategory extends CreateRecord
{
    protected static string $resource = PolicyCategoryResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
