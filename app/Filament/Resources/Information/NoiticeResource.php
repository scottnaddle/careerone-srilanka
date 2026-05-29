<?php

namespace App\Filament\Resources\Information;

use App\Filament\Resources\Information\NoiticeResource\Pages;
use App\Filament\Resources\Information\NoiticeResource\RelationManagers;
use App\Models\Information\Noitice;
use App\Models\Notice;
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
use Filament\Forms\Components\Hidden;
use App\Filament\Forms\Components\CKEditor;

class NoiticeResource extends Resource
{
    protected static ?string $model = Notice::class;
    protected static ?string $slug = '/information/notice';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countNotice;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Hidden::make('is_publish')
                ->default(1),

            Forms\Components\Select::make('type')
                ->label(__('admin/dashboard.notice.type'))
                ->options(function () {
                    $option = [];
                    $noticeTypes = getCodeList('notice_type');
                    foreach ($noticeTypes as $type) {
                        $option[$type->code_id] = $type->code_name;
                    }
                    return $option;
                })
                ->required()
                ->columnSpan('w-1/2'),

            TextInput::make('title')
                ->label(__('admin/dashboard.notice.title'))
                ->required()
                ->columnSpan('w-1/2'),

            DateTimePicker::make('start_date')
                ->label(__('admin/dashboard.notice.start_time'))
                ->required()
                ->columnSpan('w-1/2'),

            DateTimePicker::make('end_date')
                ->label(__('admin/dashboard.notice.end_time'))
                ->required()
                ->after('start_date')
                ->columnSpan('w-1/2'),

            Hidden::make('created_by')
                ->default(auth()->user()->id),

            CKEditor::make('description')
                ->label(__('admin/dashboard.notice.details'))
                ->required()
                ->columnSpan('full'),
        ]);

    }

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );

        $customQuery = $searchService->searchNotice([
            'search' => request()->query('search', null),
            'search_time' => request()->query('search-time', null),
        ]);
        self::$countNotice = $customQuery->count();
        return $table
            ->query(
                $customQuery
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),
                Tables\Columns\TextColumn::make('type')
                    //->label( Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.notice.notice_type'))
                    //->rowIndex()
                    //->alignCenter(),)
                    ->html()
                    ->formatStateUsing(function ($record) {
                        return getCodeNameByCodeId('notice_type', $record->type);
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('admin/dashboard.notice.title'))
                    ->searchable()
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin/dashboard.notice.registration_date'))
                    ->sortable(),

            ])->searchPlaceholder('Title')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('admin/dashboard.notice.notice_type'))
                    ->options(function () {
                        $noticeTypes = getCodeList('notice_type');
                        $option = [];
                        foreach ($noticeTypes as $type) {
                            $option[$type->code_id] = $type->code_name;
                        }
                        return $option;
                    })
                    ->placeholder('All Notice Types')
                    ->column('type'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                // ->visible(fn($record) => $record->created_by === auth()->id() && $record->system === 'admin'),
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
            'index' => Pages\ListNoitices::route('/'),
            'create' => Pages\CreateNoitice::route('/create'),
            'view' => Pages\ViewNoitice::route('/{record}'),
            'edit' => Pages\EditNoitice::route('/{record}/edit'),
        ];
    }
}
