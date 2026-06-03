<?php

namespace App\Filament\Resources\NewsletterResource\Pages;

use App\Filament\Resources\NewsletterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletter extends CreateRecord
{
    protected static string $resource = NewsletterResource::class;
    protected static ?string $title = 'Newsletter';
    protected static bool $canCreateAnother = false;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['attachment'] = $data['attachment'] != '' ? 'storage/' . $data['attachment'] : null;
        $data['attachment_sn'] = $data['attachment_sn'] != '' ? 'storage/' . $data['attachment_sn'] : null;
        $data['attachment_tm'] = $data['attachment_tm'] != '' ? 'storage/' . $data['attachment_tm'] : null;

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
