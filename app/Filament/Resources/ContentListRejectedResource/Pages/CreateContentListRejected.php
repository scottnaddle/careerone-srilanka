<?php

namespace App\Filament\Resources\ContentListRejectedResource\Pages;

use App\Filament\Resources\ContentListRejectedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContentListRejected extends CreateRecord
{
    protected static string $resource = ContentListRejectedResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
