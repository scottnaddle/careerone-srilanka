<?php

namespace App\Filament\Resources\Information\FAQArticleResource\Pages;

use App\Filament\Resources\Information\FAQArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFAQArticles extends ListRecords
{
    protected static string $resource = FAQArticleResource::class;
    protected static ?string $breadcrumb = 'FAQ Article List';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
