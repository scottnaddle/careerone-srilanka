<?php

namespace App\Filament\Resources\Information\FAQArticleResource\Pages;

use App\Filament\Resources\Information\FAQArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFAQArticle extends EditRecord
{
    protected static string $resource = FAQArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
