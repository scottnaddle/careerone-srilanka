<?php

namespace App\Filament\Resources\Api\REQCoursesResource\Pages;

use App\Filament\Resources\Api\REQCoursesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewREQCourses extends ViewRecord
{
    protected static string $resource = REQCoursesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
