<?php

namespace App\Filament\Resources\JobInformationResource\Pages;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

use App\Filament\Resources\JobInformationResource;

class ViewJobInformation extends ViewRecord
{
    protected static string $resource = JobInformationResource::class;
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
}
