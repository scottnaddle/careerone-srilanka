<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyCategoryResource\Pages;
use App\Filament\Resources\PolicyCategoryResource\RelationManagers;
use App\Models\PolicyCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolicyCategoryResource extends Resource
{
    protected static ?string $model = PolicyCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('admin/dashboard.policy.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')->label(__('admin/dashboard.policy.description'))
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('name_sn')
                    ->label(__('admin/dashboard.policy.name_sn'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description_sn')->label(__('admin/dashboard.policy.description_sn'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_tm')
                    ->label(__('admin/dashboard.policy.name_tm'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description_tm')->label(__('admin/dashboard.policy.description_tm'))
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin/dashboard.policy.name'))
                    ->searchable()
                    ->limit(50)
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('admin/dashboard.policy.description'))
                    ->searchable()
                    ->limit(50)
                    ->sortable()
                    ->wrap(),

                    Tables\Columns\TextColumn::make('name_tm')
                    ->label(__('admin/dashboard.policy.name_tm'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50)
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description_tm')
                    ->label(__('admin/dashboard.policy.description_tm'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50)
                    ->sortable()
                    ->wrap(),

                    Tables\Columns\TextColumn::make('name_sn')
                    ->label(__('admin/dashboard.policy.name_sn'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50)
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description_sn')
                    ->label(__('admin/dashboard.policy.description_sn'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50)
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin/dashboard.policy.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('admin/dashboard.policy.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),
            ])->searchPlaceholder('Name')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPolicyCategories::route('/'),
            'create' => Pages\CreatePolicyCategory::route('/create'),
            'edit' => Pages\EditPolicyCategory::route('/{record}/edit'),
        ];
    }
}
