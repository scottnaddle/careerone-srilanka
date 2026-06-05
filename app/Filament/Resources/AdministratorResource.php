<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdministratorResource\Pages;
use App\Models\AdminUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Admin\SearchComponentAdminService;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
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
                TextInput::make('nic')
                    ->label(__('admin/dashboard.administrator.nic'))
                    ->disabled()
                    ->default(fn ($record) => $record?->nic ?? '')
                    ->columnSpan('full'),

                TextInput::make('first_name')
                    ->label(__('system.form.first_name'))
                    ->default(fn ($record) => $record?->first_name ?? '')
                    ->columnSpan('full'),

                TextInput::make('last_name')
                    ->label(__('system.form.last_name'))
                    ->default(fn ($record) => $record?->last_name ?? '')
                    ->columnSpan('full'),

                TextInput::make('email')
                    ->label(__('system.form.email'))
                    ->default(fn ($record) => $record?->email ?? '')
                    ->columnSpan('full'),

                TextInput::make('phone')
                    ->label(__('system.form.mobile'))
                    ->default(fn ($record) => $record?->phone ?? '')
                    ->columnSpan('full'),

                Select::make('tvet_type')
                    ->label(__('admin/dashboard.cgo.tvet_type'))
                    ->options(\App\Models\TvetType::pluck('head_office_name', 'head_office_code')->toArray())
                    ->default(function ($record) {
                        // Ensure the old value is properly matched, falling back to null if not available
                        return $record && $record->tvetType ? $record->tvetType->id : null;
                    })
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder(__('admin/dashboard.administrator.search_title'))
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
                }) ->html()->wrap(),
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
                    ->extraAttributes([
                        'class' => '!font-semibold'
                    ])
                ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            Action::make('activate')
                ->label(__('Activate'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => true, 'verify_at' => now(), 'verify_by' => auth()->guard('admin')->id()]);
                })
                ->extraAttributes([
                    'class' => '!font-semibold'
                ])
                ->hidden(fn ($record) => $record->active === true)
                ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
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
}
