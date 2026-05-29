<?php

namespace App\Filament\Resources\JobInformationResource\Pages;

use App\Filament\Resources\JobInformationResource;
use Filament\Resources\Pages\EditRecord;

class EditJobInformation extends EditRecord
{
    protected static string $resource = JobInformationResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = \Str::slug($data['title']);
        $data['skills'] = json_encode($data['skills']);
        $data['knowledge'] = json_encode($data['knowledge']);
        $data['related_occupations'] = json_encode($data['related_occupations']);
        $data['benefits'] = json_encode($data['benefits']);
        $data['created_by'] = auth()->guard('admin')->id(); // Assuming you use the admin guard
        if (isset($data['attachment_details']) && is_array($data['attachment_details'])) {
            foreach ($data['attachment_details'] as $file) {
                // Generate a unique file name
                $filePath = $file;
                $fileName = pathinfo($filePath, PATHINFO_BASENAME);
                $attachments[] = [
                    'path' => $filePath,
                    'file_name' => $fileName,
                ];

            }
        }
        $data['attachment_details'] = json_encode($attachments);
        return $data;
    }

    protected function beforeFill(): void
    {
        $this->record->skills = json_decode($this->record->skills, true) ?? [];
        $this->record->knowledge = json_decode($this->record->knowledge, true) ?? [];
        $this->record->related_occupations = json_decode($this->record->related_occupations, true) ?? [];
        $this->record->benefits = json_decode($this->record->benefits, true) ?? [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['attachment_details'])) {
            $attachments = json_decode($data['attachment_details'], true);
            $data['attachment_details'] = collect($attachments)->pluck('path')->toArray();
        }

        return $data;
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
