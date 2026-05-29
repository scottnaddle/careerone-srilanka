<?php

namespace App\Filament\Resources\CounselingResource\Pages;

use App\Filament\Resources\CounselingResource;
use App\Models\CgoCounseling;
use App\Models\District;
use App\Models\Institute;
use App\Models\TvetType;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCounselings extends ListRecords
{
    protected static string $resource = CounselingResource::class;
    protected static string $view = 'filament.pages.career-guidance.counseling.counseling-list';
    protected static ?string $title = '';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function showDistrict(){
        return District::all();
    }
    protected function showTvetTypes(){
        return TvetType::all();
    }
    protected function showInstitutes(){
        return Institute::orderBy('name', 'asc')->get();
    }
    protected function showCounselingType(){
        $language=app()->getLocale();
        return getCodeList('counselling_type',$language);
    }
    protected function showCounselingField(){
        $language=app()->getLocale();
        return getCodeList('counselling_field',$language);
    }
}
