<?php

namespace App\Filament\Resources\CareerExpertInterviewResource\Pages;

use App\Filament\Resources\CareerExpertInterviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerExpertInterview extends EditRecord
{
    protected static string $resource = CareerExpertInterviewResource::class;

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
