<?php

namespace App\Filament\Resources\Api\NVQCoursesResource\Pages;

use App\Filament\Resources\Api\NVQCoursesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNVQCourses extends ViewRecord
{
    protected static string $resource = NVQCoursesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
