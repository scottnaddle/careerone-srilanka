<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Xác định tên công ty
        if (($data['company_information'] ?? null) == 1) {
            $data['name'] = $data['ministry_name'] ?? null;
            $data['co_business'] = $data['organisation_name'] ?? null;
        } else {
            $data['ministry_name'] = null;
            $data['organisation_name'] = null;
        }

        // Xác định business registration number
        if (in_array($data['company_information'] ?? null, [2, 3, 6])) {
            $data['business_registration_number'] = $data['business_registration_number_1'] ?? null;
        }

        // Xóa các field không cần thiết
        unset($data['ministry_name']);
        unset($data['organisation_name']);
        unset($data['business_registration_number_1']);

        // Tạo slug
        $data['slug'] = Str::slug($data['name'] ?? 'company');

        // Set default values
        $data['active'] = true;
        $data['verified_by'] = auth()->guard('admin')->user()->id;
        $data['verified_at'] = now();
        $data['number_workers'] = $data['number_workers'] ?? 0;

        // Set is_belongs_to_naita default to false if not provided
        if (auth()->guard('admin')->user()->hasRole('naita_admin')) {
            $data['is_belongs_to_naita'] = true;
        }
        $data['is_belongs_to_naita'] = $data['is_belongs_to_naita'] ?? false;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Xử lý attachment_details
        if (isset($data['attachment_details']) && is_array($data['attachment_details'])) {
            $storedFiles = [];
            foreach ($data['attachment_details'] as $key => $filePath) {
                $storedFiles[$key + 1]['path'] = $filePath;
                $storedFiles[$key + 1]['name'] = basename($filePath);
            }
            $data['attachment_details'] = json_encode($storedFiles);
        }

        return parent::handleRecordCreation($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
