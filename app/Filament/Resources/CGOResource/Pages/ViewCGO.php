<?php

namespace App\Filament\Resources\CGOResource\Pages;

use App\Filament\Resources\CGOResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use App\Services\Admin\HandelAdminService;
use App\Models\CgoUser;
use Filament\Notifications\Notification;

class ViewCGO extends ViewRecord
{
    protected static string $resource = CGOResource::class;

    protected static string $view = 'filament.pages.membership.cgo.cgo-detail';
    protected HandelAdminService $approvalService;
    public $detailid;
    public function __construct()
    {
        $this->approvalService = app(HandelAdminService::class);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
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
        TextInput::make('full_name')
                ->label(__('system.form.full_name'))
                ->placeholder(fn() => $this->record->fullName ?? '')
                ->disabled()
                ->columnSpan('full'),
        TextInput::make('nic')
                ->label(__('admin/dashboard.administrator.nic'))
                ->placeholder(fn() => $this->record->nic ?? '')
                ->disabled()
                ->columnSpan('full'),
        TextInput::make('mobile')
            ->label(__('system.form.mobile'))
            ->placeholder(fn() => $this->record->telephone ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('email')
            ->label(__('system.form.email'))
            ->placeholder(fn() => $this->record->email ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('p_institute')
            ->label(__('admin/dashboard.cgo.institute_registration_number'))
            ->placeholder(fn() => $this->record->institute->reg_no ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('institute_name')
            ->label(__('admin/dashboard.cgo.institute_name'))
            ->placeholder(fn() => $this->record->institute->name ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('district_name')
            ->label(__('admin/dashboard.cgo.district_name'))
            ->placeholder(fn() => $this->record->district->name ?? '')
            ->disabled()
            ->columnSpan('full'),
        ];
    }


    protected function getSecondFormSchema(): array
    {
        return [
            TextInput::make('tvet_type')
            ->label(__('admin/dashboard.cgo.tvet_type'))
            ->placeholder(fn() => $this->record->institute->tvetType->head_office_name ?? '')
            ->disabled()
            ->columnSpan('full'),

        DateTimePicker::make('created_at')
            ->label(__('admin/dashboard.cgo.created_at'))
            ->native(false)
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
                ->columnSpan('full')
                ->visible(fn($record) => !is_null($record->description)),

        ];
    }
    public function handleBlock()
    {
        if (!$this->dataResource) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }

        $success = $this->approvalService->block(CgoUser::class, $this->dataResource->id);

        if ($success) {
            session()->flash('success', 'Successfully.');
            return redirect()->route('filament.admin.pages.cgo-approval-list');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
    public function handleApproval()
    {
        if (!$this->dataResource->id) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }

        $success = $this->approvalService->approve(CgoUser::class, $this->dataResource->id);

        if ($success) {
            session()->flash('success', 'User has been approved successfully.');
            return redirect()->route('filament.admin.pages.cgo-approval-list');
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
        if ($updatedRows > 0 && $updatedRows0 > 0) {
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
