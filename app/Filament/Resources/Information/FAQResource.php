<?php

namespace App\Filament\Resources\Information;

use App\Filament\Resources\Information\FAQResource\Pages;
use App\Filament\Resources\Information\FAQResource\RelationManagers;
use App\Models\Faq as ModelsFaq;
use App\Models\Information\FAQ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use App\Services\Admin\SearchComponentAdminService;
use App\Filament\Forms\Components\CKEditor;
use Filament\Forms\Components\Hidden;
use Google\Api\ResourceDescriptor\History;

class FAQResource extends Resource
{
    protected static ?string $model = ModelsFaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'FAQ';
    public static $countFAQ;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('category_name')
                    ->label('Title')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(255)
                    ->required()
                    ->rules(['required', 'max:255'])
                    ->helperText('Maximum 255 characters.')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );

        $customQuery=  $searchService->searchFAQ([
            'search' => request()->query('search', null),
            'search_time' => request()->query('search-time', null),
        ]);

        self::$countFAQ=$customQuery->count();
        return $table
            ->query(
               $customQuery
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),
//                Tables\Columns\TextColumn::make('system')
//                    ->label('Type')
//                    ->sortable(),
                Tables\Columns\TextColumn::make('category_name')
                    ->label(__('admin/dashboard.faq.title'))
                    ->sortable()->searchable()->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin/dashboard.faq.registration_date'))
                    ->sortable()->wrap(),

            ])->searchPlaceholder(__('admin/dashboard.faq.search_title'))
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // ->modifyQueryUsing(function (Builder $query) {
            //     $query->where('type', '!=', 'video');
            // });
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
            'index' => Pages\ListFAQS::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'view' => Pages\ViewFAQ::route('/{record}'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}
