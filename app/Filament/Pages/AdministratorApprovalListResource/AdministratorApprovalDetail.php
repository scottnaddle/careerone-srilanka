<?php

namespace App\Filament\Pages\AdministratorApprovalListResource;

use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Models\AdminUser;
use Filament\Notifications\Notification;
use App\Services\Admin\HandelAdminService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use GPBMetadata\Google\Api\Log;

class AdministratorApprovalDetail extends Page
{
    protected static ?string $navigationLabel = 'Admin Approval List';
    protected static ?string $navigationGroup = 'Administrator';
    protected static ?int $navigationSort = 1;
    protected ?string $heading = '';
    protected static string $view = 'filament.pages.membership.admin.admin-approval.detail';
    public $detailid;
    public $selectedReasons = [];
    public $additionalComments = '';
    public $showModal = false;
    public $reasonSelect=['The email invalid',
                          'The Telephone (Mobiile) number is invalid',
                          'Public Offical ID Number is invalid',
                          'The Institute name is invalid',
                          'Or write something'
                        ];
    protected HandelAdminService $approvalService;
    protected bool $isEditing = false;
    public $formData = [];
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    public function mount(): void
    {
        $detailId = request()->get('id');

        if (!$detailId) {
            abort(404, 'User not found.');
        }

        $adminUser = AdminUser::with('tvetType')->findOrFail($detailId);
        $this->detailid = $adminUser;

        $this->formData = [
            'nic' => $adminUser->nic,
            'first_name' => $adminUser->first_name,
            'last_name' => $adminUser->last_name,
            'email' => $adminUser->email,
            'phone' => $adminUser->phone,
            'tvet_type' => $adminUser->tvet_type,
            'created_at' => $adminUser->created_at,
        ];
    }


    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label($this->isEditing ? 'Save' : 'Edit')
                ->icon($this->isEditing ? 'heroicon-o-check' : 'heroicon-o-pencil')
                ->action($this->isEditing ? 'save' : 'toggleEditMode')
                ->color($this->isEditing ? 'success' : 'primary')
            ->extraAttributes([
                'class' => 'rounded-xl'
            ]),
        ];
    }

    public function toggleEditMode()
    {
        $this->isEditing = !$this->isEditing;
    }

    public function save()
    {
        $this->validate([
            'formData.first_name' => 'required|string|max:255',
            'formData.last_name' => 'required|string|max:255',
            'formData.email' => 'required|email',
            'formData.phone' => 'required',
        ]);

        $this->detailid->save();
        $adminUser = AdminUser::with('tvetType')->findOrFail($this->detailid->id);
        $adminUser->first_name = $this->formData['first_name'];
        $adminUser->last_name = $this->formData['last_name'];
        $adminUser->email = $this->formData['email'];
        $adminUser->phone = $this->formData['phone'];
        $adminUser->tvet_type = $this->formData['tvet_type'];
        $adminUser->save();


        $this->isEditing = false;

        Notification::make()
            ->title('Updated successfully!')
            ->success()
            ->send();
    }
//    protected function getFirstFormSchema(): array
//    {
//            return [
//                TextInput::make('nic')
//                    ->label('NIC')
//                    ->placeholder($this->detailid->nic ?? '')
//                    ->disabled()
//                    ->columnSpan('full'),
//
//                TextInput::make('name')
//                    ->label('Name')
//                    ->placeholder(fn () => $this->detailid->fullName)
//                    ->disabled()
//                    ->columnSpan('full'),
//
//                TextInput::make('email')
//                    ->label('E-mail')
//                    ->disabled()
//                    ->placeholder(fn () => $this->detailid->fullName)
//                    ->columnSpan('full'),
//
//                TextInput::make('phone')
//                    ->disabled()
//                    ->placeholder(fn () => $this->detailid->phone)
//                    ->columnSpan('full'),
//
//                TextInput::make('tvet_type')
//                    ->label(__('admin/dashboard.cgo.tvet_type'))
//                    ->placeholder(fn () => $this->detailid->tvetType->head_office_name??'')
//                    ->disabled()
//                    ->columnSpan('full'),
//                DateTimePicker::make('created_at')
//                    ->label('Sign-up date')
//                    ->native(false)
//                    ->placeholder(fn () => $this->detailid->created_at)
//                    ->columnSpan('full'),
//            ];
//    }
    protected function getFirstFormSchema(): array
    {
        return [
            TextInput::make('formData.nic')
                ->label(__('admin/dashboard.administrator.nic'))
                ->disabled()
                ->placeholder($this->detailid?->nic ?? '')
                ->columnSpan('full'),

            TextInput::make('formData.first_name')
                ->label(__('system.form.first_name'))
                ->disabled(fn() => !$this->isEditing)
                ->placeholder(fn () => $this->detailid?->first_name ?? '')
                ->columnSpan('full'),

            TextInput::make('formData.last_name')
                ->label(__('system.form.last_name'))
                ->disabled(fn() => !$this->isEditing)
                ->placeholder(fn () => $this->detailid?->last_name ?? '')
                ->columnSpan('full'),

            TextInput::make('formData.email')
                ->label(__('system.form.email'))
                ->disabled(fn() => !$this->isEditing)
                ->placeholder(fn () => $this->detailid?->email ?? '')
                ->columnSpan('full'),

            TextInput::make('formData.phone')
                ->label(__('system.form.mobile'))
                ->disabled(fn() => !$this->isEditing)
                ->placeholder(fn () => $this->detailid?->phone ?? '')
                ->columnSpan('full'),

            Select::make('formData.tvet_type')
                ->label(__('admin/dashboard.cgo.tvet_type'))
                ->options($this->getTvetTypeOptions())
                ->disabled(fn() => !$this->isEditing)
                ->columnSpan('full'),

            TextInput::make('created_at')
                ->label(__('admin/dashboard.cgo.created_at'))
                ->disabled() // Always disabled
                ->placeholder(fn () => date("Y-m-d", strtotime($this->detailid?->created_at)))
                ->dehydrated(false) // Prevent sending it when saving
                ->hidden(fn () => $this->isEditing )
                ->columnSpan('full'),
        ];
    }
    protected function getTvetTypeOptions(): array
    {
        return \App\Models\TvetType::pluck('head_office_name', 'head_office_code')->toArray();
    }
    protected function getSecondFormSchema(): array
    {
        return [
            TextInput::make('institute_name')
            ->label('Institute')
            ->placeholder(fn () => $this->detailid->institute->name ??'')
            ->disabled()
            ->columnSpan('full'),
            TextInput::make('district_name')
                ->label('District')
                ->placeholder(fn () => $this->detailid->district->name?? '')
                ->disabled()
                ->columnSpan('full'),
                TextInput::make('tvet_type')
                ->label(__('admin/dashboard.cgo.tvet_type'))
                ->disabled()
                ->columnSpan('full'),


        ];
    }


    public function showApprovalModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function approveItem()
    {
        if (!$this->detailid) {
            Notification::make()
            ->title('User ID not found')
            ->success()
            ->send();
            return;
        }else if(!$this->additionalComments){
            Notification::make()
            ->title('Reason for rejection is required')
            ->danger()
            ->send();
            return;
        }

        $success = $this->approvalService->rejectCgo(AdminUser::class, $this->detailid->id,$this->additionalComments);

        if ($success) {
            Notification::make()
            ->title('Action Success!')
            ->success()
            ->send();
            return redirect()->route('filament.admin.pages.administrator-approval-list');
        } else {
            Notification::make()
            ->title('Something wrong !')
            ->danger()
            ->send();
        }
        $this->closeModal();
    }
    public function toggleReason($reason)
    {
        if (in_array($reason, $this->selectedReasons)) {
            $this->selectedReasons = array_diff($this->selectedReasons, [$reason]);
        } else {
            $this->selectedReasons[] = $reason;
        }
    }
    public function handleApproval()
    {
        if (!$this->detailid) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }

        $success = $this->approvalService->approve(AdminUser::class, $this->detailid->id);

        if ($success) {
            session()->flash('success', 'User has been approved successfully.');
            return redirect()->route('filament.admin.pages.administrator-approval-list');
        } else {
            session()->flash('error', 'User not found.');
        }
    }

}
