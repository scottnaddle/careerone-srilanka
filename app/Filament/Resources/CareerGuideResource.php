<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerGuideResource\Pages;
use App\Filament\Resources\CareerGuideResource\RelationManagers;
use App\Models\CareerGuidance;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;

class CareerGuideResource extends Resource
{
    protected static ?string $model = CareerGuidance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label(__('admin/dashboard.career_guidance.title')),
            Forms\Components\Select::make('category_id')
                ->label(__('admin/dashboard.career_guidance.category_id'))
                ->relationship('category', 'name')
                ->required(),
        
            FileUpload::make('thumbnail')
                ->directory('career-guides/thumbnails/') ->label(__('admin/dashboard.career_guidance.thumbnail'))
                ->imageEditor()
                ->preserveFilenames()
                ->columnSpan('full')->required()
                ->reactive()
                ->optimize('webp'),
            Forms\Components\Textarea::make('intro')
                ->label(__('admin/dashboard.career_guidance.intro'))
                ->maxLength(500),
            Forms\Components\TextInput::make('video_url')
                ->label(__('admin/dashboard.career_guidance.video_url'))
                ->url(),
            Hidden::make('system')
                ->default('admin'),
            Forms\Components\Hidden::make('status')
                ->default(true),
            Forms\Components\Hidden::make('created_by')
                ->default(auth()->id()),
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

                TextColumn::make('title')->label(__('admin/dashboard.career_guidance.title'))->sortable()->searchable() ->limit(50),
                TextColumn::make('category.name')->label(__('admin/dashboard.career_guidance.category_id'))->sortable(),
                TextColumn::make('created_at')->date('Y-m-d')->label(__('admin/dashboard.career_guidance.created_at'))->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
            ])->searchPlaceholder('Title')
            ->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category')
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
            'index' => Pages\ListCareerGuides::route('/'),
            'create' => Pages\CreateCareerGuide::route('/create'),
            'edit' => Pages\EditCareerGuide::route('/{record}/edit'),
        ];
    }
}
