<?php

namespace App\Filament\Resources\NewsletterResource\Pages;

use App\Filament\Resources\NewsletterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletter extends EditRecord
{
    protected static string $resource = NewsletterResource::class;
    protected static ?string $title = 'Newsletter';
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['attachment'] = $data['attachment'] != '' ? 'storage/' . $data['attachment'] : null;
        $data['attachment_sn'] =  $data['attachment_sn'] != '' ? 'storage/' . $data['attachment_sn'] : null;
        $data['attachment_tm'] = $data['attachment_tm'] != '' ? 'storage/' . $data['attachment_tm'] : null;

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
{
    // Strip 'storage/' when displaying again in the edit form
    if (!empty($data['attachment'])) {
        $data['attachment'] = str_replace('storage/', '', $data['attachment']);
    }

    if (!empty($data['attachment_sn'])) {
        $data['attachment_sn'] = str_replace('storage/', '', $data['attachment_sn']);
    }

    if (!empty($data['attachment_tm'])) {
        $data['attachment_tm'] = str_replace('storage/', '', $data['attachment_tm']);
    }

    return $data;
}
}
