<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\PackagesResource\Pages;
use App\Filament\Resources\Api\PackagesResource\RelationManagers;
use App\Models\NVQLevel;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackagesResource extends Resource
{
    protected static ?string $model = NVQLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'NVQ Level';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.package.index'))
                ->rowIndex()
                ->alignCenter(),
        
            TextColumn::make('code')
                ->label(__('admin/dashboard.package.code'))
                ->sortable()
                ->searchable(),
        
            TextColumn::make('version')
                ->label(__('admin/dashboard.package.version')),
        
            TextColumn::make('name')
                ->label(__('admin/dashboard.package.name'))
                ->sortable()
                ->limit(50)
                ->searchable(),
        
            TextColumn::make('level')
                ->label(__('admin/dashboard.package.level'))
                ->sortable(),
        
            TextColumn::make('ncs_code')
                ->label(__('admin/dashboard.package.ncs_code'))
                ->sortable(),
        
            TextColumn::make('ncs_name')
                ->label(__('admin/dashboard.package.ncs_name'))
                ->sortable(),
        ])
        ->paginated([10, 25, 50, 100])
        ->searchPlaceholder('Name or Code')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListPackages::route('/'),
            // 'create' => Pages\CreatePackages::route('/create'),
            // 'view' => Pages\ViewPackages::route('/{record}'),
            // 'edit' => Pages\EditPackages::route('/{record}/edit'),
        ];
    }
}
