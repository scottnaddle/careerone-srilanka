<?php

namespace App\Filament\Resources\AdministratorResource\Pages;

use App\Filament\Resources\AdministratorResource;
use Filament\Actions;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use App\Services\Admin\HandelAdminService;
use App\Models\AdminUser;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Spatie\Permission\Models\Role;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdministratorResource::class;
    protected HandelAdminService $approvalService;

    public $dataResource;
    public $isNaitaAdmin = false;
    public $isSuperAdmin = false;
    public $isAdmin = false;

    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nic')
                                    ->label(__('admin/dashboard.administrator.nic'))
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->nic ?? ''),

                                TextInput::make('fullName')
                                    ->label(__('admin/dashboard.administrator.name'))
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->fullName ?? ''),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label(__('admin/dashboard.administrator.email'))
                                    ->email()
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->email ?? ''),

                                TextInput::make('phone')
                                    ->label(__('system.form.mobile'))
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->phone ?? ''),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Placeholder::make('user_role')
                                    ->label('Role')
                                    ->content(fn () => $this->getRoleBadge())
                                    ->extraAttributes(['class' => 'filament-forms-placeholder-content']),

                                TextInput::make('tvet_type')
                                    ->label(__('admin/dashboard.cgo.tvet_type'))
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->tvet_type ?? 'N/A'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('created_at')
                                    ->label(__('admin/dashboard.administrator.sign_up_date'))
                                    ->native(false)
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->created_at),

                                Placeholder::make('status')
                                    ->label('Status')
                                    ->content(fn () => $this->getStatusBadge())
                                    ->extraAttributes(['class' => 'filament-forms-placeholder-content']),
                            ]),
                    ])->columns(1)
        ->collapsible()
        ->collapsed(fn () => !$this->record->verify_at),

                Section::make('Additional Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('updated_at')
                                    ->label('Last Updated')
                                    ->native(false)
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->updated_at),

                                TextInput::make('username')
                                    ->label('Username')
                                    ->disabled()
                                    ->formatStateUsing(fn () => $this->record->username ?? 'N/A'),
                            ]),
                    ])->columns(1)
                    ->collapsible()
                    ->collapsed(true),
            ]);
    }

    protected function getHeaderActions(): array
    {
        $actions = [
            Actions\EditAction::make()
                ->color('primary')
                ->icon('heroicon-o-pencil')
                ->label('Edit'),
        ];

        // Chỉ hiển thị action gán role nếu là super_admin
        if (auth('admin')->user()->hasRole('super_admin')) {
            $actions[] = Actions\Action::make('assign_role')
                ->label('Manage Roles')
                ->icon('heroicon-o-shield-check')
                ->color('warning')
                ->form([
                    Select::make('role')
                        ->label('Assign Role')
                        ->options([
                            'admin' => 'TVET Admin',
                            'naita_admin' => 'NAITA Admin',
                            'super_admin' => 'Super Admin',
                        ])
                        ->placeholder('Select a role to assign')
                        ->helperText('Assigning a new role will replace the current role'),
                    Toggle::make('remove_role')
                        ->label('Remove all roles')
                        ->helperText('Check this to remove all roles from this user')
                        ->default(false),
                ])
                ->action(function (array $data) {
                    $this->handleRoleAssignment($data);
                });
        }

        // Thêm action approve nếu chưa được verify
        if (!$this->record->verify_at && auth('admin')->user()->hasRole('super_admin')) {
            $actions[] = Actions\Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->handleApproval();
                });
        }

        return $actions;
    }

    public function mount($record): void
    {
        parent::mount($record);
        $this->dataResource = $this->record;
        $this->loadUserRoles();
    }

    /**
     * Load user roles
     */
    protected function loadUserRoles(): void
    {
        if ($this->dataResource) {
            $this->isNaitaAdmin = $this->dataResource->hasRole('naita_admin');
            $this->isSuperAdmin = $this->dataResource->hasRole('super_admin');
            $this->isAdmin = $this->dataResource->hasRole('admin');
        }
    }

    /**
     * Handle role assignment
     */
    protected function handleRoleAssignment(array $data): void
    {
        try {
            if ($data['remove_role'] ?? false) {
                // Remove all roles
                $this->dataResource->syncRoles([]);

                Notification::make()
                    ->title('All roles removed')
                    ->body('User has been removed from all roles.')
                    ->warning()
                    ->send();
            } elseif (!empty($data['role'])) {
                $role = Role::findByName($data['role'], 'admin');

                if ($role) {
                    // Kiểm tra role hiện tại
                    $currentRoles = $this->dataResource->getRoleNames()->toArray();

                    // Xử lý theo từng loại role
                    if ($data['role'] === 'super_admin') {
                        $this->dataResource->syncRoles([$role]);

                        Notification::make()
                            ->title('Role assigned successfully')
                            ->body("User has been assigned as Super Admin. All other roles have been removed.")
                            ->success()
                            ->send();

                    } elseif ($data['role'] === 'naita_admin') {
                        $this->dataResource->syncRoles([$role]);
                        $this->dataResource->update(['tvet_type' => 'NAITA']);

                        Notification::make()
                            ->title('Role assigned successfully')
                            ->body("User has been assigned as NAITA Admin. TVET Type has been set to NAITA.")
                            ->success()
                            ->send();

                    } elseif ($data['role'] === 'admin') {
                        if ($this->dataResource->hasRole('naita_admin')) {
                            $this->dataResource->removeRole('naita_admin');
                        }

                        if (!$this->dataResource->hasRole('admin')) {
                            $this->dataResource->assignRole($role);
                        }

                        Notification::make()
                            ->title('Role assigned successfully')
                            ->body("User has been assigned as Admin.")
                            ->success()
                            ->send();
                    }

                    // Reload the record and refresh the form
                    $this->record->refresh();
                    $this->fillForm();
                    $this->loadUserRoles();

                } else {
                    Notification::make()
                        ->title('Role not found')
                        ->body('The selected role does not exist.')
                        ->danger()
                        ->send();
                }
            }

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error assigning role')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Handle approval
     */
    protected function handleApproval(): void
    {
        try {
            $this->dataResource->update([
                'verify_at' => now(),
                'verify_by' => auth()->guard('admin')->id(),
                'active' => true,
            ]);

            Notification::make()
                ->title('Administrator Approved')
                ->body('The administrator has been approved successfully.')
                ->success()
                ->send();

            $this->refresh();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error approving administrator')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Refresh the current page
     */
    protected function refresh(): void
    {
        $this->redirect(request()->url());
    }

    /**
     * Get role badge HTML
     */
    protected function getRoleBadge(): HtmlString
    {
        if ($this->isSuperAdmin) {
            return new HtmlString('<span style="background-color: #8B5CF6; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">🔐 Super Admin</span>');
        } elseif ($this->isNaitaAdmin) {
            return new HtmlString('<span style="background-color: #10B981; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">🏢 NAITA Admin</span>');
        } elseif ($this->isAdmin) {
            return new HtmlString('<span style="background-color: #3B82F6; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">👤 Admin</span>');
        } else {
            return new HtmlString('<span style="background-color: #6B7280; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">❌ No Role</span>');
        }
    }

    protected function getStatusBadge(): HtmlString
    {
        $status = $this->dataResource->statusAdminUser();

        return match ($status) {
            'Verified' => new HtmlString('<span style="background-color: #4984F6; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">✅ Verified</span>'),
            'Request' => new HtmlString('<span style="background-color: #F59E0B; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">⏳ Request</span>'),
            default => new HtmlString('<span style="background-color: #EF4444; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">❌ Rejected</span>'),
        };
    }

    protected function getActiveStatusBadge(): HtmlString
    {
        if ($this->dataResource->active) {
            return new HtmlString('<span style="background-color: #10B981; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">🟢 Active</span>');
        } else {
            return new HtmlString('<span style="background-color: #6B7280; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">⚫ Inactive</span>');
        }
    }

    // Giữ lại các method cũ nếu cần
    public function handleBlock()
    {
        if (!$this->dataResource) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }

        $success = $this->approvalService->block(AdminUser::class, $this->dataResource->id);

        if ($success) {
            session()->flash('success', 'Successfully.');
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

        $updatedRows = $this->dataResource->UserReActive()
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
