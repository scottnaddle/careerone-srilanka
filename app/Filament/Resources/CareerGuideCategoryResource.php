<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerGuideCategoryResource\Pages;
use App\Filament\Resources\CareerGuideCategoryResource\RelationManagers;
use App\Models\CareerGuidanceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class CareerGuideCategoryResource extends Resource
{
    protected static ?string $model = CareerGuidanceCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Category Name')->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->label('Slug')
                    ->hidden()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Str::slug($state))),
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

                TextColumn::make('name')
                ->label(__('admin/dashboard.career_guidance.name'))
                ->limit(50)
                ->sortable()->searchable()
                ->wrap(),
//                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('created_at')
                ->label(__('admin/dashboard.career_guidance.created_at'))
                ->label('Created At')->dateTime()
                ->wrap(),
            ])->searchPlaceholder('Name')
            ->reorderable('sort')
            ->defaultSort('sort', 'asc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])->searchPlaceholder('Title')->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->filters([
                //
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
            'index' => Pages\ListCareerGuideCategories::route('/'),
            'create' => Pages\CreateCareerGuideCategory::route('/create'),
            'edit' => Pages\EditCareerGuideCategory::route('/{record}/edit'),
        ];
    }
}
