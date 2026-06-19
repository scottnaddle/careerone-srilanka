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
use Filament\Forms\Components\Toggle;
use Spatie\Permission\Models\Role; // Add this use statement

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
    public $isNaitaAdmin = false; // Add this property

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

        // Check whether the user already has the naita_admin role
        $this->isNaitaAdmin = $adminUser->hasRole('naita_admin');

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

        $adminUser = AdminUser::with('tvetType')->findOrFail($this->detailid->id);
        $adminUser->first_name = $this->formData['first_name'];
        $adminUser->last_name = $this->formData['last_name'];
        $adminUser->email = $this->formData['email'];
        $adminUser->phone = $this->formData['phone'];
        $adminUser->tvet_type = $this->formData['tvet_type'];
        $adminUser->save();

        // Handle assigning the naita_admin role
        $this->handleNaitaAdminRole($adminUser);

        $this->isEditing = false;

        Notification::make()
            ->title('Updated successfully!')
            ->success()
            ->send();
    }

    /**
     * Handle assigning or removing the naita_admin role
     */
    protected function handleNaitaAdminRole($adminUser)
    {
        $role = Role::findByName('naita_admin', 'admin');
        $adminRole = Role::findByName('admin', 'admin');

        if ($this->isNaitaAdmin) {
            // If the toggle is on, assign the role if not already present
            if (!$adminUser->hasRole('naita_admin')) {
                $adminUser->removeRole($adminRole);
                $adminUser->assignRole($role);
            }
        } else {
            // If the toggle is off, remove the role if present
            if ($adminUser->hasRole('naita_admin')) {
                $adminUser->removeRole($role);
                $adminUser->assignRole($adminRole);
            }
        }
    }

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

            // Add a toggle for NAITA Admin
            Toggle::make('isNaitaAdmin')
                ->label('NAITA Admin')
                ->helperText('Assign NAITA Admin role to this user')
                ->disabled(fn() => !$this->isEditing)
                ->onColor('success')
                ->offColor('danger')
                ->columnSpan('full'),

            TextInput::make('created_at')
                ->label(__('admin/dashboard.cgo.created_at'))
                ->disabled()
                ->placeholder(fn () => date("Y-m-d", strtotime($this->detailid?->created_at)))
                ->dehydrated(false)
                ->hidden(fn () => $this->isEditing)
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
        } else if(!$this->additionalComments){
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
