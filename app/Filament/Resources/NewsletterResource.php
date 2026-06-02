<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterResource\Pages;
use App\Filament\Resources\NewsletterResource\RelationManagers;
use App\Models\NewLetter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
class NewsletterResource extends Resource
{
    protected static ?string $model = NewLetter::class;
    protected static ?string $breadcrumb = 'Newsletter';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('admin/dashboard.new_letter.details'))
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label(__('admin/dashboard.policy.name'))
                                ->required()
                                ->columnSpan(2)
                                ->maxLength(255),
                            TextInput::make('title_sn')
                                ->label(__('admin/dashboard.policy.name_sn'))
                                ->required()
                                ->maxLength(255),
                            TextInput::make('title_tm')
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
                        Forms\Components\Select::make('newsletter_category_id')
                            ->label(__('admin/dashboard.new_letter.newsletter_category_id'))
                            ->relationship('newsletterCategory', 'name')
                            ->required(),

                        FileUpload::make('thumbnail')
                            ->label(__('admin/dashboard.new_letter.thumbnail'))
                            ->image()
                            ->required()
                            ->preserveFilenames()
                            ->maxSize(51200)
                            ->optimize('webp'),

                        Grid::make(3)->schema([
                            FileUpload::make('attachment')
                                ->label(__('admin/dashboard.new_letter.pdf_attachment'))
                                ->acceptedFileTypes(['application/pdf'])
                                ->directory('newsletter')
                                ->preserveFilenames()
                                ->openable()
                                ->downloadable()
                                ->maxSize(51200)
                                ->required()
                                ->optimize('webp'),

                            FileUpload::make('attachment_sn')
                                ->label(__('admin/dashboard.new_letter.pdf_attachment_sn'))
                                ->acceptedFileTypes(['application/pdf'])
                                ->directory('newsletter')
                                ->preserveFilenames()
                                ->openable()
                                ->downloadable()
                                ->maxSize(51200)
                                ->optimize('webp'),

                            FileUpload::make('attachment_tm')
                                ->label(__('admin/dashboard.new_letter.pdf_attachment_tm'))
                                ->acceptedFileTypes(['application/pdf'])
                                ->directory('newsletter')
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

                Tables\Columns\TextColumn::make('title')
                ->label(__('admin/dashboard.new_letter.title'))
                ->limit(50)
                ->sortable()->searchable()
                ->wrap(),
                Tables\Columns\TextColumn::make('description')
                ->label(__('admin/dashboard.new_letter.description'))
                ->limit(50)
                ->wrap(),
                Tables\Columns\TextColumn::make('attachment')
                    ->label(__('admin/dashboard.new_letter.pdf_attachment'))
                    ->formatStateUsing(fn ($state) => 'View PDF') // Display 'View PDF'
                    ->url(fn ($record) => asset($record->attachment))
                    ->openUrlInNewTab()
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                ->label(__('admin/dashboard.career_expert_interview.created_at'))
                ->dateTime()->sortable()
                ->wrap(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
            ])->searchPlaceholder('Title')
            ->filters([
                Tables\Filters\SelectFilter::make('newsletter_category_id')
                    ->label('Category')
                    ->relationship('newsletterCategory', 'name')
                    ->placeholder('All Categories'), // Optional: Default label
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('created_at', 'desc'); // Order by latest by default
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
            'index' => Pages\ListNewsletters::route('/'),
            'create' => Pages\CreateNewsletter::route('/create'),
            'edit' => Pages\EditNewsletter::route('/{record}/edit'),
        ];
    }
}
