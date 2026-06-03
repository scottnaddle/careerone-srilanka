<?php

namespace App\Filament\Resources\AdministratorResource\Pages;

use App\Filament\Resources\AdministratorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;


class EditAdministrator extends EditRecord
{
    protected static string $resource = AdministratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Set is_naita_admin dựa trên role
        $data['is_naita_admin'] = $this->record->hasRole('naita_admin');

        // Set tvet_type nếu là NAITA Admin
        if ($data['is_naita_admin']) {
            $data['tvet_type'] = 'NAITA';
        }

        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {

            unset($data['password']);
        }
        if (isset($data['is_naita_admin']) && $data['is_naita_admin'] === true) {
            $data['tvet_type'] = 'NAITA';
        }
        $data['active'] = true;
        $data['verify_at'] = now();
        $data['verify_by'] = auth()->guard('admin')->id() ?? null;
        return $data;
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        $administrator = $this->record;
        $data = $this->form->getRawState();

        // Gọi handleRoleAssignment để xử lý role và tvet_type
        if (isset($data['is_naita_admin'])) {
            AdministratorResource::handleRoleAssignment($administrator, $data['is_naita_admin'], $data);
        }
    }
}
