<?php

namespace App\Filament\Resources\CGOResource\Pages;

use App\Filament\Resources\CGOResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TvetType;
use App\Models\Institute;
use Carbon\Carbon;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ListCGOS extends ListRecords
{
    protected static string $resource = CGOResource::class;
    protected static string $view = 'filament.pages.membership.cgo.cgo-list';
    public function getBreadcrumbs(): array
    {
        return [];
    }
    public function getTitle(): string {
        return '';
    }
    protected function getHeaderActions(): array
    {
        return [

            Actions\CreateAction::make(),
        ];
    }



    // Corrected method signature to allow query filtering
    protected function getTVET()
    {
        return TvetType::get();
    }
    protected function getInstitute()
    {
        return Institute::orderBy('name', 'asc')->get();
    }
    protected function getTotal()
    {
        return CGOResource::$totalCgo;
    }
}
