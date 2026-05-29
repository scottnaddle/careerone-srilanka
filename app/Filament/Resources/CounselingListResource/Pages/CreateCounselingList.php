<?php

namespace App\Filament\Resources\CounselingListResource\Pages;

use App\Filament\Resources\CounselingListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCounselingList extends CreateRecord
{
    protected static string $resource = CounselingListResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
