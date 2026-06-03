<?php

namespace App\Filament\Resources\CgoRejectListResource\Pages;

use App\Filament\Resources\CgoRejectListResource;
use App\Models\CgoUser;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Services\Admin\HandelAdminService;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
class ViewCgoRejectList extends ViewRecord
{
    protected static string $resource = CgoRejectListResource::class;
    protected HandelAdminService $approvalService;
    protected static string $view = 'filament.pages.membership.cgo.cgo-reject.cgo-reject-detail';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    public $traineeData;

    public function mount($record): void
    {
        parent::mount($record);
        $this->traineeData = $this->record;
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
                ->placeholder(fn () => $this->record->district->name?? '')
                ->disabled()
                ->columnSpan('full'),



        ];
    }

    protected function getSecondFormSchema(): array
    {
        return [
            TextInput::make('institute_name')
            ->label('Institute')
            ->placeholder(fn () => $this->record->institute->name)
            ->disabled()
            ->columnSpan('full'),
            TextInput::make('district_name')
                ->label('District')
                ->placeholder(fn () => $this->record->district->name?? '')
                ->disabled()
                ->columnSpan('full'),
                TextInput::make('tvet_type')
                ->label(__('admin/dashboard.cgo.tvet_type'))
                ->disabled()
                ->columnSpan('full'),
        ];
    }

    protected function getThirdFormSchema(): array
{
    return [
        Textarea::make('description')
            ->label('Reason for reject')
            ->placeholder('Enter your description here...')
            ->rows(4)
            ->columnSpan('full'),
    ];
}
public function handleApproval()
{
    if (!$this->detailid) {
        session()->flash('error', 'User ID is required for approval.');
        return;
    }
    $success = $this->approvalService->approve(CgoUser::class, $this->detailid->id);

    if ($success) {
        session()->flash('success', 'User has been approved successfully.');
        return redirect()->route('filament.admin.resources.c-g-o-s.index');
    } else {
        session()->flash('error', 'User not found.');
    }
}
}
