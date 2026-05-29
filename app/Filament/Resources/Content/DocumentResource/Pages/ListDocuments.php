<?php

namespace App\Filament\Resources\Content\DocumentResource\Pages;

use App\Filament\Resources\Content\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }
    public function getBreadcrumbs(): array {
        return [
            'Information',
            'Content',
            'Documents'
        ];
    }
}
