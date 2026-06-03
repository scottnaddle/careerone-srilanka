<?php

namespace App\Filament\Resources\ApprovedCGODetailResource\Pages;

use App\Filament\Resources\ApprovedCGODetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedCGODetail extends EditRecord
{
    protected static string $resource = ApprovedCGODetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
