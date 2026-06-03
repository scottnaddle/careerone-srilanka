<?php

namespace App\Filament\Resources\TraineeResource\Pages;

use App\Filament\Resources\TraineeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainee extends EditRecord
{
    protected static string $resource = TraineeResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\ViewAction::make(),
//            Actions\DeleteAction::make(),
//        ];
//    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
