<?php

namespace App\Filament\Resources\Information\Content\ContentAppovalListResource\Pages;

use App\Filament\Resources\Information\Content\ContentAppovalListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentAppovalList extends EditRecord
{
    protected static string $resource = ContentAppovalListResource::class;

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
