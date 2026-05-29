<?php

namespace App\Filament\Resources\CareerExpertInterviewResource\Pages;

use App\Filament\Resources\CareerExpertInterviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerExpertInterviews extends ListRecords
{
    protected static string $resource = CareerExpertInterviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
