<?php

namespace App\Filament\Resources\Information\Content;

use App\Filament\Resources\Information\Content\EventApprovalListResource\Pages;
use App\Filament\Resources\Information\Content\EventApprovalListResource\RelationManagers;
use App\Models\Event;
use App\Models\Information\Content\EventApprovalList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\Admin\SearchComponentAdminService;

use Filament\Forms\Components\Hidden;


class EventApprovalListResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countEvnet;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('event_type')
                        ->label('Event Type')
                        ->relationship('categoryModule', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpan('w-1/2'),
                        TextInput::make('title')
                            ->label('Title')
                            ->columnSpan('w-2/3')
                            ->required()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $slug = Str::slug($state);
                                $set('slug', $slug);
                            }),
                    ])
                    ->columnSpan('full'),
                \Filament\Forms\Components\Grid::make()
                    ->schema([
                        DateTimePicker::make('start_time')
                            ->label('Start Time')
                            ->required()
                            ->columnSpan('w-1/2'),

                        DateTimePicker::make('end_time')
                            ->label('End Time')
                            ->required()
                            ->columnSpan('w-1/2'),
                    ])
                    ->columnSpan('full'),

                // Các ô khác
                Forms\Components\Hidden::make('sort')
                ->label('Sort')
                ->default(function () {
                    $currentSortValue = Event::max('sort');
                    return ($currentSortValue ?? 0) + 1;
                }),
                Hidden::make('system')
                    ->default('admin')
                    ->columnSpan('full'),

                Hidden::make('slug')
                    ->label('Slug')
                    ->dehydrated(fn($state) => !is_null($state)),

                Hidden::make('status')
                    ->default(\App\Enums\StatusEnumsManagement::APPROVED->value),

                Hidden::make('created_by')
                    ->default(Auth::id())
                    ->label('Created by'),

                RichEditor::make('details')
                    ->label('Detail')
                    ->required()
                    ->columnSpan('full'),

                FileUpload::make('thumbnail')
                    ->directory('storage/cgo/events/thumbnails/' . Auth::id())
                    ->imageEditor()
                    ->required()
                    ->preserveFilenames()
                    ->columnSpan('full')
                    ->optimize('webp'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
        $customQuery = $searchService->searchEvent([
            'search' => request()->query('search', null),
            'type' => request()->query('type', null),
            'member' => request()->query('member', null),
            'search_time' => request()->query('search-time', null),
        ]);
        self::$countEvnet = $customQuery->count();
        return $table
        ->paginated([10, 25, 50, 100])
            ->query(
                $customQuery
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label(__('admin/dashboard.event.title'))
                    ->wrap(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->limit(50)
                    ->label(__('admin/dashboard.event.title_table'))
                    ->wrap(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Author')
                    ->wrap(),
                Tables\Columns\TextColumn::make('event_type')
                ->label(__('admin/dashboard.event.event_type'))
                    ->html()
                    ->formatStateUsing(function ($record) {
                        return getCodeNameByCodeId('event_type', $record->event_type);
                    }),
                Tables\Columns\TextColumn::make('system')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return match ($record->system) {
                            'cgo' => 'CGO',
                            'company' => 'Company',
                            'admin' => 'Admin',
                            default => $record,
                        };
                    })
                    ->label(__('admin/dashboard.event.member'))
                    ->wrap(),
                Tables\Columns\TextColumn::make('approval')
                ->label(__('admin/dashboard.event.status'))
                ->getStateUsing(fn($record) => $record->status == \App\Enums\StatusEnumsManagement::APPROVED->value ?
                __('admin/status.approved') :
                ($record->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value ?
                __('admin/status.non_approval') : __('admin/status.pending_approval')))
                ->formatStateUsing(function ($state) {
                    if ($state === 'Approval') {
                        return "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>";
                    }
                    return "<span style='font-size:12px;color: #5a5252; background-color: #d3d3d3; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>$state</span>";
                })
                ->html(),
            ])->searchPlaceholder('Title')
            ->filters([
                Tables\Filters\SelectFilter::make('event_type')
                    ->label('Event Type')
                    ->options(function () {
                        $eventTypes = getCodeList('event_type', 'en');
                        $option = [];
                        foreach ($eventTypes as $type) {
                            $option[$type->code_id] = $type->code_name;
                        }
                        return $option;
                    })
                    ->placeholder('All Event Types')
                    ->column('event_type'),
                Tables\Filters\SelectFilter::make('system')
                    ->label('Select member')
                    ->options([
                        'cgo' => 'CGO',
                        'company' => 'Company',
                        'admin' => 'Admin'
                    ])
                    ->placeholder('All Member')
                    ->column('system'),
            ])
            ->actions([
                //  Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),
            ])
            ->striped()
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
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
            'index' => Pages\ListEventApprovalLists::route('/'),
            'create' => Pages\CreateEventApprovalList::route('/create'),
            'view' => Pages\ViewEventApprovalList::route('/{record}'),
            //'edit' => Pages\EditEventApprovalList::route('/{record}/edit'),
        ];
    }
}
