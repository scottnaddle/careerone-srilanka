<?php

namespace App\Filament\Resources\PolicyResource\Pages;

use App\Filament\Resources\PolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePolicy extends CreateRecord
{
    protected static string $resource = PolicyResource::class;
    protected static bool $canCreateAnother = false;
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['file'] = 'storage/' . $data['file'];
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $attachments = [];
    //     if (isset($data['file'])) {
    //         // Generate a unique file name
    //         $filePath = $data['file'];
    //         $fileName = pathinfo($filePath, PATHINFO_BASENAME);
    //         $attachments[] = [
    //             'path' => $filePath,
    //             'file_name' => $fileName,
    //         ];
    //     }
    //     $data['file'] = json_encode($attachments);

    //     return $data;
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
