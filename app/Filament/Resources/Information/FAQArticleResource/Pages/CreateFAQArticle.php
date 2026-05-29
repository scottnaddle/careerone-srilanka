<?php

namespace App\Filament\Resources\Information\FAQArticleResource\Pages;

use App\Filament\Resources\Information\FAQArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFAQArticle extends CreateRecord
{
    protected static string $resource = FAQArticleResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return FAQArticleResource::getUrl('index');
    }
}
