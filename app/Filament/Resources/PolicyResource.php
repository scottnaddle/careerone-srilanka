<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyResource\Pages;
use App\Filament\Resources\PolicyResource\RelationManagers;
use App\Models\Policy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
class PolicyResource extends Resource
{
    protected static ?string $model = Policy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make(__('admin/dashboard.new_letter.details'))
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label(__('admin/dashboard.policy.name'))
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),
                        TextInput::make('name_sn')
                            ->label(__('admin/dashboard.policy.name_sn'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_tm')
                            ->label(__('admin/dashboard.policy.name_tm'))
                            ->required()
                            ->maxLength(255),
                    ]),
                    Grid::make(1)->schema([
                        Textarea::make('description')
                            ->label(__('admin/dashboard.new_letter.description'))
                            ->required(),
                        Textarea::make('description_sn')
                            ->label(__('admin/dashboard.policy.description_sn'))
                            ->required(),
                        Textarea::make('description_tm')
                            ->label(__('admin/dashboard.policy.description_tm'))
                            ->required(),
                    ]),
                ]),

            Section::make(__('admin/dashboard.new_letter.attachments'))
                ->schema([
                    Select::make('category_id')
                    ->label(__('admin/dashboard.policy.policy_category'))
                    ->relationship('category', 'name')
                    ->required(),
                    Grid::make(3)->schema([
                        FileUpload::make('file')
                        ->required()
                        ->label(__('admin/dashboard.policy.policy_document'))
                        ->directory('policies')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable()
                        ->maxSize(51200)
                        ->optimize('webp'),

                        FileUpload::make('file_sn')
                            ->label(__('admin/dashboard.policy.policy_document_sn'))
                            ->directory('policies')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->maxSize(51200)
                            ->optimize('webp'),

                        FileUpload::make('file_tm')
                            ->label(__('admin/dashboard.policy.policy_document_tm'))
                            ->directory('policies')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->maxSize(51200)
                            ->optimize('webp'),
                    ]),
                ]),
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
                ->limit(50)
                    ->searchable()->wrap(),
                Tables\Columns\TextColumn::make('description')
                ->label(__('admin/dashboard.policy.description'))
                    ->searchable()->wrap(),
                Tables\Columns\TextColumn::make('file')
                ->label(__('admin/dashboard.policy.file'))
                    ->searchable()->wrap(),
                Tables\Columns\TextColumn::make('category_id')
                ->label(__('admin/dashboard.policy.category_id'))
                    ->numeric()
                    ->sortable()->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                ->label(__('admin/dashboard.policy.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)->wrap(),
                Tables\Columns\TextColumn::make('updated_at')
                ->label(__('admin/dashboard.policy.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)->wrap(),
            ])->searchPlaceholder(__('admin/dashboard.policy.name'))
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
            'index' => Pages\ListPolicies::route('/'),
            'create' => Pages\CreatePolicy::route('/create'),
            'edit' => Pages\EditPolicy::route('/{record}/edit'),
        ];
    }
}
