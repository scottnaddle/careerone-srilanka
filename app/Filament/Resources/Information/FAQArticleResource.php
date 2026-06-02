<?php

namespace App\Filament\Resources\Information;

use App\Filament\Resources\Information\FAQArticleResource\Pages;
use App\Filament\Resources\Information\FAQArticleResource\RelationManagers;
use App\Models\FaqArticle as ModelsFaqArticle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Forms\Components\CKEditor;

class FAQArticleResource extends Resource
{
    protected static ?string $model = ModelsFaqArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'FAQ Article';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('faq_id')
                ->label(__('admin/dashboard.faq_article.category'))
                ->relationship('faq', 'category_name')
                ->searchable()
                ->preload()
                ->required()
                ->columnSpan('full'),

            TextInput::make('question')
                ->label(__('admin/dashboard.faq_article.title'))
                ->required()
                ->columnSpan('full'),
            TextInput::make('url')
                ->label(__('Video URL'))
                ->url()
                ->columnSpan('full'),
            CKEditor::make('answer')
                ->label(__('admin/dashboard.faq_article.detail'))
                ->required()
                ->columnSpan('full'),

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
                Tables\Columns\TextColumn::make('faq.category_name')
                    ->label(__('admin/dashboard.faq_article.category'))
                    ->sortable()->wrap(),
                Tables\Columns\TextColumn::make('question')
                    ->label(__('admin/dashboard.faq_article.question'))
                    ->searchable()
                    ->limit(50)
                    ->sortable()->wrap(),
               Tables\Columns\TextColumn::make('url')
                   ->label('Url')
                   ->searchable()
                   ->limit(50)
                   ->sortable()->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin/dashboard.faq_article.registration_date'))
                    ->sortable()->wrap(),
            ])->searchPlaceholder(__('admin/dashboard.faq_article.question_title'))
            ->filters([
                Tables\Filters\SelectFilter::make('newsletter_category_id')
                    ->label('Category')
                    ->relationship('faq', 'category_name')
                    ->placeholder('All Categories'),
                Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_at'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when($data['created_at'] ?? null, fn($query, $date) => $query->whereDate('created_at', '=', $date));
                }),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('updated_at', 'desc')
             ->reorderable()
            ;

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
            'index' => Pages\ListFAQArticles::route('/'),
            'create' => Pages\CreateFAQArticle::route('/create'),
            'view' => Pages\ViewFAQArticle::route('/{record}'),
            'edit' => Pages\EditFAQArticle::route('/{record}/edit'),
        ];
    }
}
