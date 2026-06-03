<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages;
use App\Filament\Resources\ResourceResource\RelationManagers;
use App\Models\Resource as ResourceModel;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResourceResource extends Resource
{
    protected static ?string $model = ResourceModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Resource';
    protected static ?string $navigationGroup = 'Content';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\Textarea::make('intro')->rows(3)->required()->columnSpanFull(),
                Forms\Components\Select::make('content_type')->options([
                        'video' => 'Video',
                        'document' => 'Document',
                ])
                ->required()
                ->live(),

                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name') // assuming relation `category()`
                    ->required(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('thumbnails')
                    ->preserveFilenames()
                    ->disk('public')
                    ->maxSize(51200)->columnSpanFull()
                    ->optimize('webp')->required(),
                Forms\Components\TextInput::make('video_url')->url()->visible(fn (Forms\Get $get) => $get('content_type') === 'video')->columnSpanFull(),
                Forms\Components\FileUpload::make('attachment_details')
                    ->label(__('company.my_page.attachment'))
                    ->directory('resources')
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    ->maxSize(51200)
                    ->required()
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'document')->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),

                Tables\Columns\TextColumn::make('content_type')->sortable()->alignCenter()->formatStateUsing(fn ($state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('views')->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')->dateTime("Y-m-d"),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('primary'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListResources::route('/'),
            'create' => Pages\CreateResource::route('/create'),
            'edit' => Pages\EditResource::route('/{record}/edit'),
            'view' => Pages\ViewResource::route('/{record}'),
        ];
    }
}
