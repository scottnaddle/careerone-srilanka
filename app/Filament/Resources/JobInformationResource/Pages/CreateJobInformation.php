<?php

namespace App\Filament\Resources\JobInformationResource\Pages;

use App\Filament\Resources\JobInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateJobInformation extends CreateRecord
{
    protected static string $resource = JobInformationResource::class;
    protected static bool $canCreateAnother = false;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Str::slug($data['title']);
        $data['related_occupations'] = json_encode(array_filter($data['related_occupations'], function($occupation) {
            return isset($occupation['occupation']) && $occupation['occupation'] !== null && $occupation['occupation'] !== '';
        }));
        $data['benefits'] = json_encode(array_filter($data['benefits'], function($benefit) {
            return isset($benefit['benefit']) && $benefit['benefit'] !== null && $benefit['benefit'] !== '';
        }));
        $data['skills'] = json_encode(array_filter($data['skills'], function($skill) {
            return isset($skill['text']) && $skill['text'] !== null;
        }));
        $data['knowledge'] = json_encode(array_filter($data['knowledge'], function($knowledge) {
            return isset($knowledge['text']) && $knowledge['text'] !== null;
        }));
        $data['created_by'] = auth()->guard('admin')->id(); // Assuming you use the admin guard
        $attachments = [];
        // Generate the full paths and save them
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
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['attachment_details'])) {
            $attachments = json_decode($data['attachment_details'], true);
            $data['attachment_details'] = collect($attachments)->pluck('path')->toArray();
        }

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
