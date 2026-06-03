<?php

namespace App\Filament\Resources\ComapnyUserListResource\Pages;

use App\Filament\Resources\ComapnyUserListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;

class EditComapnyUserList extends EditRecord
{
    protected static string $resource = ComapnyUserListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
//            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
