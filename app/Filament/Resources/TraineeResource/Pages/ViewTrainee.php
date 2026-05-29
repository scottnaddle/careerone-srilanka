<?php

namespace App\Filament\Resources\TraineeResource\Pages;

use App\Filament\Resources\TraineeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeInformationService;
use App\Services\Trainee\TraineeTrainingSyncService;
use App\Models\TraineeTrainingHistory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;

class ViewTrainee extends ViewRecord
{
    protected static string $resource = TraineeResource::class;
    protected static string $view = 'filament.pages.membership.trainee.trainee';

    protected function getHeaderActions(): array
    {
        return [
             Actions\EditAction::make(),
        ];
    }
    public function getBreadcrumbs(): array
    {
        return [];
    }
    public function getTitle(): string {
        return '';
    }
    public $traineeInformationService;
    public $traineeSyncService;

    public $traineeData;
    public $traineeInformation;

    public function mount($record): void
    {

        parent::mount($record);
        $this->traineeData = $this->record;

        $current_user = TraineeTrainingHistory::where('trainee_id',$this->traineeData->id)->first();
        if(!empty($current_user)){
            $this->traineeInformation=$current_user->content != null ? json_decode($current_user->content) : null;
            $this->traineeCertificate=$current_user->nvq_content != null ? json_decode($current_user->nvq_content) : null;
        }

    }



    protected function getFirstFormSchema(): array
    {
        return [
            TextInput::make('nic')
            ->label(__('admin/dashboard.trainee.nic'))
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('name')
            ->label(__('admin/dashboard.trainee.name'))
            ->placeholder(fn () => $this->record->fullName)
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('email')
            ->label(__('admin/dashboard.trainee.email'))
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('mobile')
            ->disabled()
            ->columnSpan('full'),

//        TextInput::make('institute_name')
//            ->label(__('admin/dashboard.trainee.institute_name'))
//            ->placeholder(fn () => getInstituteName($this->record->institutes()->latest()->first()->id))
//            ->disabled()
//            ->columnSpan('full'),
            TextInput::make('institute_name')
                ->label(__('admin/dashboard.trainee.institute_name'))
                ->placeholder(function () {
                    $institute = $this->record->institutes()->latest()->first();
                    return $institute ? getInstituteName($institute->id) : '';
                })
                ->disabled()
                ->columnSpan('full'),

        DateTimePicker::make('created_at')
            ->label(__('admin/dashboard.trainee.created_at'))
            ->native(false)
            ->columnSpan('full'),

//        TextInput::make('district_name')
//            ->label(__('admin/dashboard.trainee.district_name'))
//            ->placeholder(fn () => $this->record->district->name?? '')
//            ->disabled()
//            ->columnSpan('full'),


        ];
    }

    protected function getSecondFormSchema(): array
    {
        return [
            TextInput::make('full_name')
            ->label(__('admin/dashboard.trainee.full_name'))
            ->placeholder(fn () =>$this->record->full_name?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('Email')
            ->label(__('admin/dashboard.trainee.email'))
            ->placeholder(fn () => $this->record->email?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('mobile')
            ->label(__('admin/dashboard.trainee.telephone'))
            ->placeholder(fn () => $this->record->telephone ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('contact_address')
            ->label(__('admin/dashboard.trainee.address'))
            ->disabled()
            ->columnSpan('full'),

        ];
    }

    protected function getThirdFormSchema(): array
{
    return [
        TextInput::make('nvq')
            ->label('NVQ')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('field_2')
            ->label('Field 2')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('field_3')
            ->label('Field 3')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('field_4')
            ->label('Field 4')
            ->disabled()
            ->columnSpan('full'),
    ];
}
public function getMyInformation() {

}
public function handleApprovalActive()
{
    if (!$this->record || !$this->record->id) {
        session()->flash('error', 'User ID is required for approval.');
        return;
    }
    $updatedRows0 = $this->record->update([
        'active' => true,
    ]);
    $updatedRows=$this->record->UserReActive()
    ->whereNull('confirmed_at')
    ->update([
        'confirmed_at' => now(),
    ]);
    if ($updatedRows > 0 && $updatedRows0) {
        Notification::make()
            ->title('Approved successfully!')
            ->success()
            ->send();
    } else {
        Notification::make()
            ->title('No records to approve!')
            ->warning()
            ->send();
    }
        return redirect()->route('filament.admin.resources.user-re-actives.index');

}
}
