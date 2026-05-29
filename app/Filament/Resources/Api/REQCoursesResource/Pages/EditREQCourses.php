<?php

namespace App\Filament\Resources\Api\REQCoursesResource\Pages;

use App\Filament\Resources\Api\REQCoursesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditREQCourses extends EditRecord
{
    protected static string $resource = REQCoursesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
