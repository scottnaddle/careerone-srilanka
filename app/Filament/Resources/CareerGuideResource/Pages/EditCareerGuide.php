<?php

namespace App\Filament\Resources\CareerGuideResource\Pages;

use App\Filament\Resources\CareerGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\WithFileUploads;

class EditCareerGuide extends EditRecord
{
    use WithFileUploads;
    protected static string $resource = CareerGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = \Str::slug($data['title'], '-', 'ta');
        // $data['thumbnail'] = str_starts_with($data['thumbnail'], 'storage/') ? $data['thumbnail'] : 'storage/' . $data['thumbnail'];
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
