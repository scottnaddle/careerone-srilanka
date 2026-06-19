<?php

namespace App\Filament\Resources\ComapnyUserListResource\Pages;

use App\Filament\Resources\ComapnyUserListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComapnyUserLists extends ListRecords
{
    protected static string $resource = ComapnyUserListResource::class;
    protected static ?string $breadcrumb = 'List';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin') || auth('admin')->user()->hasRole('naita_admin')),
        ];
    }
}
