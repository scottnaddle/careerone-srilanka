<?php

namespace App\Filament\Resources\AdminRoleResource\Pages;

use App\Filament\Resources\AdminRoleResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use App\Models\AdminUser;
class CreateAdminRole extends CreateRecord
{
    protected static string $resource = AdminRoleResource::class;
    protected function getFormSchema(): array
    {
        return [
            Select::make('username')
                ->label('Select Admin User')
                ->options(AdminUser::pluck('username', 'id'))
                ->searchable()
                ->required(),

            Select::make('roles')
                ->relationship('roles', 'name') 
                ->multiple() 
                ->preload() 
                ->label('Assign Roles'),

            Select::make('permissions')
                ->relationship('permissions', 'name') 
                ->multiple() 
                ->preload()
                ->label('Assign Permissions'),

            TextInput::make('model_type')
                ->required()
                ->label('Model Type')
                ->default('App\Models\AdminUser')
                ->maxLength(255),
        ];
    }
}
