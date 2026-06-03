<?php

namespace App\Filament\Resources\CompanyRecruiterResource\Pages;

use App\Filament\Resources\CompanyRecruiterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyRecruiter extends CreateRecord
{
    protected static string $resource = CompanyRecruiterResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
