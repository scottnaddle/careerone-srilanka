<?php

namespace App\Filament\Resources\SectorResource\Pages;

use App\Filament\Resources\SectorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSector extends EditRecord
{
    protected static string $resource = SectorResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\DeleteAction::make(),
//        ];
//    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    public function getTitle(): string|Htmlable {
        return trans('menu.sector_management');
    }
}
