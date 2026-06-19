<?php

namespace App\Filament\Resources\CareerExpertInterviewResource\Pages;

use App\Filament\Resources\CareerExpertInterviewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCareerExpertInterview extends CreateRecord
{
    protected static string $resource = CareerExpertInterviewResource::class;
    protected static bool $canCreateAnother = false;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Str::slug($data['title'], '-', 'ta');
//        $data['thumbnail'] = 'storage/' . $data['thumbnail'];
        $data['created_by'] = \Auth::guard('admin')->user()->id;

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
