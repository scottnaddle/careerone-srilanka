<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // If it is a ministry (company_information == 1)
        if (($data['company_information'] ?? null) == 1) {
            $data['ministry_name'] = $data['name'] ?? null;
            $data['organisation_name'] = $data['co_business'] ?? null;
        }

        // If it is types 2,3,6
        if (in_array($data['company_information'] ?? null, [2, 3, 6])) {
            $data['business_registration_number_1'] = $data['business_registration_number'] ?? null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle the ministry case
        if (($data['company_information'] ?? null) == 1) {
            $data['name'] = $data['ministry_name'] ?? null;
            $data['co_business'] = $data['organisation_name'] ?? null;
        }

        // Handle types 2,3,6
        if (in_array($data['company_information'] ?? null, [2, 3, 6])) {
            $data['business_registration_number'] = $data['business_registration_number_1'] ?? null;
        }

        // Remove the temporary fields
        unset($data['ministry_name']);
        unset($data['organisation_name']);
        unset($data['business_registration_number_1']);

        // Handle the slug
        if (isset($data['name'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        // Process attachment_details
        if (isset($data['attachment_details']) && is_array($data['attachment_details'])) {
            // Only process if it is an array (newly uploaded files)
            $storedFiles = [];
            foreach ($data['attachment_details'] as $key => $filePath) {
                if (is_string($filePath)) {
                    $storedFiles[$key + 1]['path'] = $filePath;
                    $storedFiles[$key + 1]['name'] = basename($filePath);
                }
            }
            if (!empty($storedFiles)) {
                $data['attachment_details'] = json_encode($storedFiles);
            }
        }

        // If active is enabled but verified_by is not yet set
        if (($data['active'] ?? false) && empty($this->record->verified_by)) {
            $data['verified_by'] = auth()->guard('admin')->user()->id;
            $data['verified_at'] = now();
        }

        // If active is disabled, clear the verified info
        if (!($data['active'] ?? false)) {
            $data['verified_by'] = null;
            $data['verified_at'] = null;
        }

        return $data;
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
