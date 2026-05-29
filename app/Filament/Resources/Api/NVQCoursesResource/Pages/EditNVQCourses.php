<?php

namespace App\Filament\Resources\Api\NVQCoursesResource\Pages;

use App\Filament\Resources\Api\NVQCoursesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNVQCourses extends EditRecord
{
    protected static string $resource = NVQCoursesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
