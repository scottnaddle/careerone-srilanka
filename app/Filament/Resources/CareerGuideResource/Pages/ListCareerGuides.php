<?php

namespace App\Filament\Resources\CareerGuideResource\Pages;

use App\Filament\Resources\CareerGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerGuides extends ListRecords
{
    protected static string $resource = CareerGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
