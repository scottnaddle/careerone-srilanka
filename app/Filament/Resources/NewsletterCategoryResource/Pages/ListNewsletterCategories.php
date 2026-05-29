<?php

namespace App\Filament\Resources\NewsletterCategoryResource\Pages;

use App\Filament\Resources\NewsletterCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterCategories extends ListRecords
{
    protected static string $resource = NewsletterCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
