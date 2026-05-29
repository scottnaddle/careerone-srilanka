<?php

namespace App\Filament\Resources\UserReActiveResource\Pages;

use App\Filament\Resources\UserReActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserReActive extends EditRecord
{
    protected static string $resource = UserReActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
