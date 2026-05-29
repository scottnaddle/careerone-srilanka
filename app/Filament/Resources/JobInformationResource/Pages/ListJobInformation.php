<?php

namespace App\Filament\Resources\JobInformationResource\Pages;

use App\Filament\Resources\JobInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobInformation extends ListRecords
{
    protected static string $resource = JobInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
