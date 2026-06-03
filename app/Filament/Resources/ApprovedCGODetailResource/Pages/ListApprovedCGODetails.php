<?php

namespace App\Filament\Resources\ApprovedCGODetailResource\Pages;

use App\Filament\Resources\ApprovedCGODetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovedCGODetails extends ListRecords
{
    protected static string $resource = ApprovedCGODetailResource::class;
    protected static ?string $breadcrumb = null;
    public function getBreadcrumb(): string
    {
        return __('menu.approved_cgo_details');
    }
    public function getBreadcrumbs(): array
    {
        return [
            __('menu.membership'),
            __('menu.cgo'),
            $this->getResource()::getUrl('index') => __('menu.approved_cgo_details'),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
