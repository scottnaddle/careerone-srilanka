<?php

namespace App\Filament\Resources\Information\NoiticeResource\Pages;

use App\Filament\Resources\Information\NoiticeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNoitice extends ViewRecord
{
    protected static string $resource = NoiticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
