<?php

namespace App\Filament\Resources\Information\FAQArticleResource\Pages;

use App\Filament\Resources\Information\FAQArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFAQArticle extends ViewRecord
{
    protected static string $resource = FAQArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
