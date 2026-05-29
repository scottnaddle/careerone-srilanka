<?php

namespace App\Filament\Resources\CounselingListResource\Pages;

use App\Filament\Resources\CounselingListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCounselingLists extends ListRecords
{
    protected static string $resource = CounselingListResource::class;
    protected static ?string $breadcrumb = 'Guidance list';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
