<?php

namespace App\Filament\Resources\CareerGuideResource\Pages;

use App\Filament\Resources\CareerGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Livewire\WithFileUploads;

class CreateCareerGuide extends CreateRecord
{
    use WithFileUploads;
    protected static string $resource = CareerGuideResource::class;
    protected static bool $canCreateAnother = false;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Str::slug($data['title'], '-', 'ta');
        // $data['thumbnail'] = 'storage/' . $data['thumbnail'];
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
