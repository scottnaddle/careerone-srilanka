<?php

namespace App\Filament\Resources\Api\PackagesResource\Pages;

use App\Filament\Resources\Api\PackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackages extends EditRecord
{
    protected static string $resource = PackagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
