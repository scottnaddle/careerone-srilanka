<?php

namespace App\Filament\Resources\UserReActiveResource\Pages;

use App\Filament\Resources\UserReActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserReActive extends ViewRecord
{
    protected static string $resource = UserReActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
