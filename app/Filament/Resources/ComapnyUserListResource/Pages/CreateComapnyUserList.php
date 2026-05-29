<?php

namespace App\Filament\Resources\ComapnyUserListResource\Pages;

use App\Filament\Resources\ComapnyUserListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComapnyUserList extends CreateRecord
{
    protected static string $resource = ComapnyUserListResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
