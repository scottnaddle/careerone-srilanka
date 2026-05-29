<?php

namespace App\Filament\Resources\Information\Content\ContentListResource\Pages;

use App\Filament\Resources\Information\Content\ContentListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentList extends EditRecord
{
    protected static string $resource = ContentListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
