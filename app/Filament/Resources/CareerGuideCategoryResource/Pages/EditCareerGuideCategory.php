<?php

namespace App\Filament\Resources\CareerGuideCategoryResource\Pages;

use App\Filament\Resources\CareerGuideCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerGuideCategory extends EditRecord
{
    protected static string $resource = CareerGuideCategoryResource::class;
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = \Str::slug($data['name']);
        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
