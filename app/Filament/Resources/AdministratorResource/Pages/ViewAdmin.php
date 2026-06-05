<?php

namespace App\Filament\Resources\AdministratorResource\Pages;

use App\Filament\Resources\AdministratorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use App\Services\Admin\HandelAdminService;
use App\Models\AdminUser;
use Filament\Notifications\Notification;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdministratorResource::class;
    protected static string $view = 'filament.pages.membership.admin.admin-detail';
    protected HandelAdminService $approvalService;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->color('primary')->icon('heroicon-o-pencil'),
        ];
    }
    public $dataResource;

    public function mount($record): void
    {
        parent::mount($record);
        $this->dataResource = $this->record;
    }


    protected function getFirstFormSchema(): array
    {
        return [
            TextInput::make('nic')
                ->label(__('admin/dashboard.administrator.nic'))
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('name')
                ->label(__('admin/dashboard.administrator.name'))
                ->placeholder(fn () => $this->record->fullName)
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('email')
                ->label(__('admin/dashboard.administrator.email'))
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('phone')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('tvetType.head_office_name')
                ->label(__('admin/dashboard.cgo.tvet_type'))
                ->placeholder(fn () => $this->record->tvetType->head_office_name ?? '')
                ->disabled()
                ->columnSpan('full'),

            DateTimePicker::make('created_at')
                ->label(__('admin/dashboard.administrator.sign_up_date'))
                ->native(false)
                ->columnSpan('full'),
        ];

    }

    protected function getSecondFormSchema(): array
    {
        return [
            // TextInput::make('institute_name')
            // ->label('Institute')
            // ->placeholder(fn () => $this->record->institute->name??'')
            // ->disabled()
            // ->columnSpan('full'),
            // TextInput::make('district_name')
            //     ->label('Location')
            //     ->placeholder(fn () => $this->record->district->name?? '')
            //     ->disabled()
            //     ->columnSpan('full'),
            //     TextInput::make('tvet_type')
            //     ->label('TVET Type')
            //     ->disabled()
            //     ->columnSpan('full'),
            //     TextInput::make('sector')
            //     ->label('Sector')
            //     ->disabled()
            //     ->columnSpan('full'),
            //     TextInput::make('course')
            //     ->label('Cource')
            //     ->disabled()
            //     ->columnSpan('full'),
            //     TextInput::make('nvq')
            //     ->placeholder(fn () => $this->record->nvq->name ?? 'N/A')
            //     ->label('NVQ')
            //     ->disabled()
            //     ->columnSpan('full'),

        ];
    }

 protected function getThirdFormSchema(): array
{
    return [
        // Textarea::make('description')
        //     ->label('Reason for refusal')
        //     ->placeholder('Enter your description here...')
        //     ->rows(4)
        //     ->columnSpan('full'),
    ];
}
public function handleBlock()
{
    if (!$this->dataResource) {
        session()->flash('error', 'User ID is required for approval.');
        return;
    }

    $success = $this->approvalService->block(AdminUser::class, $this->dataResource->id);

    if ($success) {
        session()->flash('success', 'Successfully.');
//        return redirect()->route('filament.admin.pages.administrator-approval-list');
        return redirect()->route('filament.admin.resources.administrators.index');
    } else {
        session()->flash('error', 'User not found.');
    }
}
public function handleApprovalActive()
{
    if (!$this->dataResource || !$this->dataResource->id) {
        session()->flash('error', 'User ID is required for approval.');
        return;
    }
    $updatedRows0 = $this->dataResource->update([
        'verify_at' => now(),
        'verify_by' => auth()->guard('admin')->id(),
        'active' => true,
    ]);
    $updatedRows=$this->dataResource->UserReActive()
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
