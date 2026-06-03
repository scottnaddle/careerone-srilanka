<?php

namespace App\Filament\Resources\CompanyRecruiterResource\Pages;

use App\Filament\Resources\CompanyRecruiterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;

class EditCompanyRecruiter extends EditRecord
{
    protected static string $resource = CompanyRecruiterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
//            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
