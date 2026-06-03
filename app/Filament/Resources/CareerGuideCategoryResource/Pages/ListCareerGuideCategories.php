<?php

namespace App\Filament\Resources\CareerGuideCategoryResource\Pages;

use App\Filament\Resources\CareerGuideCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerGuideCategories extends ListRecords
{
    protected static string $resource = CareerGuideCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
