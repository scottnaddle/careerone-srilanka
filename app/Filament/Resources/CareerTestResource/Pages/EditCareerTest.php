<?php

namespace App\Filament\Resources\CareerTestResource\Pages;

use App\Filament\Resources\CareerTestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerTest extends EditRecord
{
    protected static string $resource = CareerTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
