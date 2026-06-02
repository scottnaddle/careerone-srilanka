<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CodeManagementResource\Pages;
use App\Filament\Resources\CodeManagementResource\RelationManagers;
use App\Models\CategorySystem;
use App\Models\CodeManagement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;

class CodeManagementResource extends Resource
{
    protected static ?string $model = CodeManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('code_name_en')
                ->label(__('admin/dashboard.code_management.code_name_en'))
                ->required(),
            TextInput::make('code_name_tm')
                ->label(__('admin/dashboard.code_management.code_name_tm'))
                ->required(),
            TextInput::make('code_name_sn')
                ->label(__('admin/dashboard.code_management.code_name_sn'))
                ->required(),
                TextInput::make('code_id')
                    ->label(__('admin/dashboard.code_management.code_id'))
                    ->disabledOn('edit')
                    ->required(),
                
            Select::make('module')
                ->label(__('admin/dashboard.code_management.module'))
                ->options(function () {
                    return CategorySystem::query()
                        ->pluck('module', 'module')
                        ->toArray();
            })
                ->disabledOn('edit')
                ->required(),
            Select::make('status')
                ->label(__('admin/dashboard.code_management.status'))
                ->options([
                    '0' => __('admin/dashboard.code_management.show'),
                    '1' => __('admin/dashboard.code_management.hide'),
                ])
                ->required()
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.code_management.index'))
                ->rowIndex()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('module')
                ->label(__('admin/dashboard.code_management.module'))
//                ->searchable()
                ->sortable()
                ->wrap(),

            Tables\Columns\TextColumn::make('code_name_en')
                ->label(__('admin/dashboard.code_management.code_name_en'))
                ->searchable()
                ->sortable()
                ->wrap(),

            Tables\Columns\TextColumn::make('code_name_tm')
                ->label(__('admin/dashboard.code_management.code_name_tm'))
                ->searchable()
                ->sortable()
                ->wrap(),

            Tables\Columns\TextColumn::make('code_name_sn')
                ->label(__('admin/dashboard.code_management.code_name_sn'))
                ->searchable()
                ->sortable()
                ->wrap(),

                Tables\Columns\TextColumn::make('status')
                ->label(__('admin/dashboard.code_management.status'))
                ->sortable()
                ->formatStateUsing(function ($state) {
                    return $state ? 'Show' : 'Hide';
                })
                ->wrap(),

        ])
        ->searchPlaceholder('Code name')
            ->filters([
                Tables\Filters\SelectFilter::make('module')
                    ->label('Module')
                    ->options(function () {
                        // Get distinct 'module' values from the database
                        return CategorySystem::query()
                            ->pluck('module', 'module') // Fetch module values
                            ->toArray();
                    })
            ])->paginated([10, 25, 50, 100])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
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
            'index' => Pages\ListCodeManagement::route('/'),
            'create' => Pages\CreateCodeManagement::route('/create'),
            'view' => Pages\ViewCodeManagement::route('/{record}'),
            'edit' => Pages\EditCodeManagement::route('/{record}/edit'),
        ];
    }
}
