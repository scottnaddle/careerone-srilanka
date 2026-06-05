<?php

namespace App\Filament\Resources\AdministratorResource\Pages;

use App\Filament\Resources\AdministratorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\TvetType;

class ListAdministrators extends ListRecords
{
    protected static string $resource = AdministratorResource::class;
    protected static string $view = 'filament.pages.membership.admin.admin-list';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTVET()
    {
        return TvetType::get();
    }
    protected function getTotal()
    {
        return AdministratorResource::$totalAdmin;
    }
}
