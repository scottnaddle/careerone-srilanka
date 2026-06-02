<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterCategoryResource\Pages;
use App\Filament\Resources\NewsletterCategoryResource\RelationManagers;
use App\Models\NewsletterCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsletterCategoryResource extends Resource
{
    protected static ?string $model = NewsletterCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('admin/dashboard.new_letter.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('admin/dashboard.new_letter.description'))
                    ->nullable()
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('name_sn')
                    ->label(__('admin/dashboard.policy.name_sn'))
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_sn')->label(__('admin/dashboard.policy.description_sn'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_tm')
                    ->label(__('admin/dashboard.policy.name_tm'))
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_tm')->label(__('admin/dashboard.policy.description_tm'))
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
                    ->label(__('admin/dashboard.new_letter.name'))
                    ->sortable()
                    ->limit(50)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('description')
                    ->label(__('admin/dashboard.new_letter.description'))
                    ->limit(50)
                    ->sortable()
                    ->wrap(),
            ])->searchPlaceholder(__('admin/dashboard.new_letter.name'))
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterCategories::route('/'),
            'create' => Pages\CreateNewsletterCategory::route('/create'),
            'edit' => Pages\EditNewsletterCategory::route('/{record}/edit'),
        ];
    }
}
