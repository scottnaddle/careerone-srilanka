<?php

namespace App\Filament\Resources\TraineeResource\Pages;

use App\Filament\Resources\TraineeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Models\Sector;
use App\Models\District;
use App\Models\Province;

class ListTrainees extends ListRecords
{
    protected static string $resource = TraineeResource::class;
    // protected static string $view = 'filament.pages.membership.trainee.trainee-list';
   
    public function getBreadcrumbs(): array
    {
        return [
            __('menu.membership'),
            'Trainee',
            $this->getResource()::getUrl('index') => 'Trainee Users',
        ];
    }
    protected function getHeaderActions(): array
    {
       
        return [
            // Actions\EditAction::make(),
        ];
    }
  

    protected function getFirstFormSchema(): array
    {
        return [
            TextInput::make('nic')
                ->label('NIC')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('name')
                ->label('Name')
                ->placeholder(fn () => $this->record->fullName)
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('email')
                ->label('e-mail')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('telephone')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('institute_name')
                ->label('Institute')
                ->placeholder(fn () => $this->record->institute->name)
                ->disabled()
                ->columnSpan('full'),
            DateTimePicker::make('created_at')
                ->label('Sign-up date')
                ->native(false)
                ->columnSpan('full'),
            TextInput::make('district_name')
                ->label('Location')
                ->placeholder(fn () => $this->record->district->name)
                ->disabled()
                ->columnSpan('full'),
        ];
    }
    protected function getSector()
    {
        return Sector::get();
    }
    protected function getDistrict()
    {
        return District::get();
    }
    protected function getTotal()
    {
        return TraineeResource::$totalRecords;
    }
    protected function getProvinces(){
        return Province::get();
    }
   
}
