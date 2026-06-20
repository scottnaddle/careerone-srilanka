<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdministratorResource\Pages;
use App\Models\AdminUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Admin\SearchComponentAdminService;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Spatie\Permission\Models\Role;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class AdministratorResource extends Resource
{
    protected static ?string $model = AdminUser::class;

    protected static ?string $navigationLabel = 'Administrator List';
    protected static ?string $navigationGroup = 'Administrator';
    protected static ?int $navigationSort = 1;
    public static $totalAdmin;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('nic')
                            ->label(__('admin/dashboard.administrator.nic'))
                            ->unique(ignorable: fn ($record) => $record)
                            ->columnSpan('full'),
                        Grid::make(2)->schema([
                            TextInput::make('first_name')
                                ->label(__('system.form.first_name'))
                                ->required()
                                ->columnSpan('1/2'),
                            TextInput::make('last_name')
                                ->label(__('system.form.last_name'))
                                ->required()
                                ->columnSpan('1/2'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('email')
                                ->label(__('system.form.email'))
                                ->email()
                                ->required()
                                ->unique(ignorable: fn ($record) => $record)
                                ->columnSpan('1/2'),

                            TextInput::make('phone')
                                ->label(__('system.form.mobile'))
                                ->required()
                                ->columnSpan('1/2'),
                        ]),


                        Select::make('tvet_type')
                            ->label(__('admin/dashboard.cgo.tvet_type'))
                            ->options(\App\Models\TvetType::pluck('head_office_name', 'head_office_code')->toArray())
                            ->default(function ($record) {
                                if ($record && $record->tvet_type) {
                                    return $record->tvet_type;
                                }
                                return null;
                            })
                            ->disabled(fn ($get) => $get('is_naita_admin') === true)
                            ->helperText(fn ($get) => $get('is_naita_admin') === true ? 'TVET Type is automatically set to NAITA for NAITA Admin' : '')
                            ->required(fn ($get) => $get('is_naita_admin') !== true)
                            ->columnSpan('full'),

                        Toggle::make('is_naita_admin')
                            ->label('NAITA Admin')
                            ->helperText('Assign NAITA Admin role (will remove regular admin role)')
                            ->default(fn ($record) => $record?->hasRole('naita_admin') ?? false)
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                // Auto set tvet_type = 'NAITA' when is_naita_admin = true
                                if ($state) {
                                    $set('tvet_type', 'NAITA');
                                }
                            })
                            ->columnSpan('full'),
                    ])->columns(1),

                Section::make('Password')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('password')
                                    ->label(__('system.form.password'))
                                    ->password()
                                    ->revealable()
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->minLength(8)
                                    ->same('password_confirmation')
                                    ->helperText(trans('auth.password_feeback'))
                                    ->columnSpan(1),

                                TextInput::make('password_confirmation')
                                    ->label(trans('system.form.confirm_password'))
                                    ->password()
                                    ->revealable()
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->dehydrated(false)
                                    ->helperText('Please confirm your password') // Set helperText here
                                    ->columnSpan(1),
                            ])->columns(2)
                            ->visible(fn (string $context): bool => $context === 'create'),
                    ])
                    ->collapsible()
                    ->collapsed(fn (string $context): bool => $context === 'edit')
                    ->visible(fn (string $context): bool => $context === 'create'),

                Section::make('Change Password')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('new_password')
                                    ->label('New Password')
                                    ->password()
                                    ->revealable()
                                    ->dehydrated(false)
                                    ->minLength(8)
                                    ->same('new_password_confirmation')
                                    ->helperText('Leave blank to keep current password. Password must be at least 8 characters long.') // Set helperText here
                                    ->placeholder('Leave blank to keep current password')
                                    ->columnSpan(1),

                                TextInput::make('new_password_confirmation')
                                    ->label('Confirm New Password')
                                    ->password()
                                    ->revealable()
                                    ->dehydrated(false)
                                    ->helperText('Please confirm your new password') // Set helperText here
                                    ->columnSpan(1),
                            ])->columns(2),
                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->visible(fn (string $context): bool => $context === 'edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder(__('admin/dashboard.administrator.search_title'))->headerActions([
                \Filament\Tables\Actions\CreateAction::make(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('tvet_type')
                    ->label(__('admin/dashboard.cgo.tvet_type'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('fullName')
                    ->label(__('admin/dashboard.administrator.name'))
                    ->searchable(['first_name', 'last_name'])
                    ->getStateUsing(function ($record) {
                        return $record->fullName ?? 'N/A';
                    })->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nic')->label('NIC')->sortable()->wrap(),
                Tables\Columns\TextColumn::make('contact')->label(__('admin/dashboard.administrator.contact'))
                    ->getStateUsing(function ($record) {
                        return $record->phone .'</br>'.$record->email;
                    })->html()->wrap(),
                Tables\Columns\TextColumn::make('roles')
                    ->label('Roles')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $roles = $record->getRoleNames()->toArray();
                        return !empty($roles) ? $roles : ['No Role'];
                    })
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return implode(', ', $state);
                        }
                        return $state;
                    })
                    ->color(fn ($record) => match(true) {
                        $record->hasRole('naita_admin') => 'success',
                        $record->hasRole('admin') => 'primary',
                        default => 'gray'
                    }),
                Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/dashboard.administrator.approval'))
                    ->getStateUsing(function ($record) {
                        return $record->statusAdminUser();
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>",
                        'Request' => "<span style='font-size:12px;color: #5a5252; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Request</span>",
                        default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>Rejected</span>",
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tvetType')
                    ->relationship('tvetType', 'head_office_name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'naita_admin' => 'NAITA Admin',
                        'admin' => 'Regular Admin',
                        'no_role' => 'No Role'
                    ])
                    ->preload()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['role'])) {
                            if ($data['role'] === 'no_role') {
                                $query->whereDoesntHave('roles');
                            } else {
                                $query->role($data['role'], 'admin');
                            }
                        }
                    }),
                Tables\Filters\SelectFilter::make('approval')
                    ->options([
                        'verified' => 'Verified',
                        'recently' => 'Recently'
                    ])
                    ->preload()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['approval'])) {
                            if ($data['approval'] == 'verified') {
                                $query->whereNotNull('verify_at')
                                    ->whereNotNull('verify_by')
                                    ->whereNotNull('email_verified_at');
                            } elseif ($data['approval'] == 'recently') {
                                $query->orderBy('updated_at', 'desc');
                            }
                        }
                    }),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('date')
                            ->label('Created At')
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('created_at', $data['date']);
                        }
                    }),
            ])
            ->actions([
                Action::make('deactivate')
                    ->label(__('Deactivate'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => false, 'verify_at' => null, 'verify_by' => auth()->guard('admin')->id()]);
                    })
                    ->hidden(fn ($record) => $record->active === false)
                    ->extraAttributes(['class' => '!font-semibold'])
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

                Action::make('activate')
                    ->label(__('Activate'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => true, 'verify_at' => now(), 'verify_by' => auth()->guard('admin')->id()]);
                    })
                    ->extraAttributes(['class' => '!font-semibold'])
                    ->hidden(fn ($record) => $record->active === true)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->striped()
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->preserveScroll()
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdministrators::route('/'),
            'create' => Pages\CreateAdministrator::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdministrator::route('/{record}/edit'),
        ];
    }

    public static function handleRoleAssignment($record, bool $isNaitaAdmin, array $data = []): void
    {
        try {
            $naitaRole = Role::findByName('naita_admin', 'admin');
            $adminRole = Role::findByName('admin', 'admin');
            $updateData = [];

            // Handle the password
            $password = null;
            if (isset($data['password']) && !empty($data['password'])) {
                $password = $data['password'];
            } elseif (isset($data['new_password']) && !empty($data['new_password'])) {
                $password = $data['new_password'];
            }

            if ($isNaitaAdmin) {
                // Assign the NAITA Admin role
                if (!$record->hasRole('naita_admin')) {
                    $record->assignRole($naitaRole);
                }
                // Remove the admin role if present
                if ($record->hasRole('admin')) {
                    $record->removeRole($adminRole);
                }

                // Set tvet_type from data or default to 'NAITA'
                if (isset($data['tvet_type']) && !empty($data['tvet_type'])) {
                    $updateData['tvet_type'] = $data['tvet_type'];
                } else {
                    $updateData['tvet_type'] = 'NAITA';
                }

            } else {
                // Not a NAITA Admin, remove the NAITA Admin role if present
                if ($record->hasRole('naita_admin')) {
                    $record->removeRole($naitaRole);
                }

                // Assign the admin role if no role is present yet
                if (!$record->hasRole('admin') && !$record->hasRole('naita_admin')) {
                    $record->assignRole($adminRole);
                }

                // Set tvet_type from data (could be 'NAITA' or another value)
                if (isset($data['tvet_type']) && !empty($data['tvet_type'])) {
                    $updateData['tvet_type'] = $data['tvet_type'];
                } else {
                    $updateData['tvet_type'] = null;
                }
            }

            // Set the password if present
            if ($password) {
                $updateData['password'] = bcrypt($password);
            }

            // Update
            if (!empty($updateData)) {
                $record->update($updateData);
            }

            $message = $password ? 'Password has been updated successfully. ' : '';
            $roleMessage = $isNaitaAdmin ? 'NAITA Admin role assigned. ' : '';

            Notification::make()
                ->title('Changes saved')
                ->body($message . $roleMessage . 'Administrator information has been updated successfully.')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error updating roles')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
