<?php

namespace App\Filament\Resources\MenuResource\Pages;

// use App\Filament\Resources\MenuResource;
use Datlechin\FilamentMenuBuilder\Resources\MenuResource as BaseMenuResource;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenus extends ListRecords
{
    protected static string $resource = BaseMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
