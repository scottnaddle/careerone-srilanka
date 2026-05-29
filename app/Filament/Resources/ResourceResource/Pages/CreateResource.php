<?php

namespace App\Filament\Resources\ResourceResource\Pages;

use App\Filament\Resources\ResourceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateResource extends CreateRecord
{
    protected static string $resource = ResourceResource::class;
    protected static bool $canCreateAnother = false;
    public function mutateFormDataBeforeCreate(array $data): array {
        $data['created_by'] = Auth::guard('admin')->id();
        $data['system'] = 'admin';
        return $data;
    }
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
