<?php

namespace App\Filament\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Datlechin\FilamentMenuBuilder\Resources\MenuResource\Pages\EditMenu as EditMenuResource;
use Datlechin\FilamentMenuBuilder\Resources\MenuResource as BaseMenuResource;

class EditMenu extends EditMenuResource
{
    protected static string $resource = BaseMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
