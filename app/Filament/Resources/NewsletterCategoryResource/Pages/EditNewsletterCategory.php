<?php

namespace App\Filament\Resources\NewsletterCategoryResource\Pages;

use App\Filament\Resources\NewsletterCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterCategory extends EditRecord
{
    protected static string $resource = NewsletterCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
