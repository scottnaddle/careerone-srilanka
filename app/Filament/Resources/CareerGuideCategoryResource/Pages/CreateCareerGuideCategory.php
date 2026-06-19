<?php

namespace App\Filament\Resources\CareerGuideCategoryResource\Pages;

use App\Filament\Resources\CareerGuideCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCareerGuideCategory extends CreateRecord
{
    protected static string $resource = CareerGuideCategoryResource::class;
    protected static bool $canCreateAnother = false;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Str::slug($data['name'], '-', 'ta');
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
