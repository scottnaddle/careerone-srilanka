<?php

namespace App\Filament\Resources\OJTResource\Pages;

use App\Filament\Resources\OJTResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOjt extends EditRecord
{
    protected static string $resource = OJTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
