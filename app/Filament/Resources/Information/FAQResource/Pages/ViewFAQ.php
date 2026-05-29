<?php

namespace App\Filament\Resources\Information\FAQResource\Pages;

use App\Filament\Resources\Information\FAQResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFAQ extends ViewRecord
{
    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
