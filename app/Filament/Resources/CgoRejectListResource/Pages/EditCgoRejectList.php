<?php

namespace App\Filament\Resources\CgoRejectListResource\Pages;

use App\Filament\Resources\CgoRejectListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCgoRejectList extends EditRecord
{
    protected static string $resource = CgoRejectListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
