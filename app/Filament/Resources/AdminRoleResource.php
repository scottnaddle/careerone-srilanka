<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminRoleResource\Pages;
use App\Models\AdminUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class AdminRoleResource extends Resource
{
    protected static ?string $model = AdminUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nic')
                    ->label(__('admin/dashboard.admin_user.nic'))
                    ->nullable(),

                TextInput::make('first_name')
                    ->label(__('admin/dashboard.admin_user.first_name'))
                    ->required(),

                TextInput::make('last_name')
                    ->label(__('admin/dashboard.admin_user.last_name'))
                    ->required(),

                // TextInput::make('username')
                //     ->label(__('admin/dashboard.admin_user.username'))
                //     ->required(),

                TextInput::make('phone')
                    ->label(__('admin/dashboard.admin_user.phone'))
                    ->required(),

                TextInput::make('email')
                    ->label(__('admin/dashboard.admin_user.email'))
                    ->required(),

                TextInput::make('password')
                    ->label(__('admin/dashboard.admin_user.password'))
                    ->password()
                    ->visible(fn($livewire) => $livewire instanceof Pages\CreateAdminRole)
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateAdminRole),

                // TextInput::make('institute_id')
                //     ->label(__('admin/dashboard.admin_user.institute_id'))
                //     ->nullable(),

                // TextInput::make('district_id')
                //     ->label(__('admin/dashboard.admin_user.district_id'))
                //     ->nullable(),

                // TextInput::make('role')
                //     ->label(__('admin/dashboard.admin_user.role'))
                //     ->default(__('admin/dashboard.admin_user.default'))
                //     ->disabled()
                //     ->nullable(),

                TextInput::make('tvet_type')
                    ->label(__('admin/dashboard.admin_user.tvet_type'))
                    ->nullable(),

                TextInput::make('tvet_headquater_id')
                    ->label(__('admin/dashboard.admin_user.tvet_headquater_id'))
                    ->nullable(),

                Forms\Components\Select::make('roles')
                    ->label(__('admin/dashboard.admin_user.roles'))
                    ->relationship(name: 'roles', titleAttribute: 'name')
                    ->saveRelationshipsUsing(function (AdminUser $record, $state) {
                        $record->roles()->syncWithPivotValues($state, [config('permission.column_names.team_foreign_key') => getPermissionsTeamId()]);
                    })
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->whereNotNull('verify_at')->whereNotNull('verify_by');
            })
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('username')->label(__('admin/dashboard.admin_user.admin_name'))->wrap(),
                Tables\Columns\TextColumn::make('roles.name')->label(__('admin/dashboard.admin_user.roles'))->wrap(),
            ])
            ->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->filters([]);
    }


    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminRoles::route('/'),
            'create' => Pages\CreateAdminRole::route('/create'),
            'edit' => Pages\EditAdminRole::route('/{record}/edit'),
        ];
    }
}
