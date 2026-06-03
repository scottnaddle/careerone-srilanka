<?php

namespace App\Filament\Resources\Content;

use App\Enums\StatusEnumsManagement;
use App\Filament\Resources\Content\DocumentResource\Pages;
use App\Filament\Resources\Content\DocumentResource\RelationManagers;
use App\Models\Content;
use App\Models\Content\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DocumentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Document';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $label = 'Document Content';
    protected static ?string $pluralLabel = 'Documents';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\Textarea::make('intro')->rows(3)->required(),

                Forms\Components\TextInput::make('author')->maxLength(255),
                Forms\Components\TextInput::make('license')->maxLength(255),

                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name') // assuming relation `category()`
                    ->required(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('thumbnails')
                    ->disk('public')
                    ->maxSize(51200), // 50MB
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('content_type', '!=', 'video');
            })
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->wrap(),

                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable()->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->getStateUsing(function ($record) {
                        return match ($record->status) {
                            StatusEnumsManagement::PENDING_APPROVAL->value => __('admin/status.pending_approval'),
                            StatusEnumsManagement::APPROVED_BY_ADMIN->value => __('admin/status.approved_by_tvec'),
                            StatusEnumsManagement::REJECTED_BY_ADMIN->value => __('admin/status.rejected_by_tvec'),
                            StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value => __('admin/status.approved_by_association'),
                            StatusEnumsManagement::REJECTED_BY_ASSOCIATION->value => __('admin/status.rejected_by_association'),
                            default => __('admin/dashboard.job.unknown'),
                        };
                    })->alignCenter()->sortable()->wrap(),
                Tables\Columns\TextColumn::make('views')->alignCenter()->sortable()->wrap(),
                Tables\Columns\TextColumn::make('created_by')
                ->getStateUsing(function ($record) {
                    return $record->getAuthor($record->system, $record->created_by)->fullName;
                })->alignCenter()->sortable()->wrap(),
                Tables\Columns\TextColumn::make('created_at')->dateTime("Y-m-d")->sortable()->alignCenter(),

            ])->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('status', 'asc')
                    ->orderBy('created_at', 'asc');
            })
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(function () {
                        $eventStatus = \App\Enums\StatusEnumsManagement::cases();
                        $option = [];
                        foreach ($eventStatus as $statusEnum) {
                            $option[$statusEnum->value] = \App\Enums\StatusEnumsManagement::getStatusName($statusEnum->value);
                        }
                        return $option;
                    })
                    ->placeholder('All status')
                    ->column('status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('primary'),
//                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('editCategory')
                    ->label('Edit Category')
                    ->action(function (Content $record, array $data) {
                        return $record->editCategory($data['category_id']); // Custom method to edit the category
                    })
                    ->form([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name') // Relationship to the 'category' table
                            ->required()->default(fn (Content $record) => $record->category_id),
                    ])
                    ->modalWidth('lg')
            ])->searchPlaceholder(__('Title'))
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
            'index' => Pages\ListDocuments::route('/'),
//            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
            'view' => Pages\ViewDocument::route('/{record}'),
        ];
    }
}
