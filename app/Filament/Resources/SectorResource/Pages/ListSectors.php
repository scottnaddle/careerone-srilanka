<?php

namespace App\Filament\Resources\SectorResource\Pages;

use App\Filament\Resources\SectorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListSectors extends ListRecords
{
    protected static string $resource = SectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable {
        return trans('menu.sector_management');
    }
}
