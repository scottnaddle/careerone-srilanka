<?php

namespace App\Filament\Resources\UserReActiveResource\Pages;

use App\Filament\Resources\UserReActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserReActives extends ListRecords
{

    protected static string $resource = UserReActiveResource::class;
    protected static ?string $breadcrumb ='Reactive Account List';
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
