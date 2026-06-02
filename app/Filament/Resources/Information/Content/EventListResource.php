<?php

namespace App\Filament\Resources\Information\Content;

use App\Filament\Resources\Information\Content\EventListResource\Pages;
use App\Filament\Resources\Information\Content\EventListResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use App\Filament\Forms\Components\CKEditor;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Actions\Action;
class EventListResource extends Resource
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
                    Select::make('event_type')
                        ->label(__('admin/dashboard.event.event_type'))
                        ->options(function () {
                            $eventTypes = getCodeList('event_type', 'en');
                            $option = [];
                            foreach ($eventTypes as $type) {
                                $option[$type->code_id] = $type->code_name;
                            }
                            return $option;
                        })
                        ->required()
                        ->columnSpan('w-1/2'),

                    TextInput::make('title')
                        ->label(__('admin/dashboard.event.title'))
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
                        ->label(__('admin/dashboard.event.start_time'))
                        ->required()
                        ->columnSpan('w-1/2'),

                    DateTimePicker::make('end_time')
                        ->label(__('admin/dashboard.event.end_time'))
                        ->required()
                        ->after('start_time')
                        ->columnSpan('w-1/2'),
                ])
                ->columnSpan('full'),

            \Filament\Forms\Components\Grid::make()
                ->schema([
                    FileUpload::make('thumbnail')
                    ->disk('public') // Chỉ định disk 'public'
                    ->directory('cgo/events/thumbnails/temp') // Bỏ 'storage/'
                    ->imageEditor()
                    ->required()
                    ->preserveFilenames()
                    ->columnSpan('w-1/2')
                    ->optimize('webp')
                    ,


                    TextInput::make('place')
                        ->label(__('admin/dashboard.event.place'))
                        ->columnSpan('w-2/3'),
                ]),

            // Các ô khác
            Hidden::make('system')
                ->default('admin')
                ->columnSpan('full'),

            Hidden::make('slug')
                ->label(__('admin/dashboard.event.slug'))
                ->dehydrated(fn($state) => !is_null($state)),

            Hidden::make('status')
                ->default(\App\Enums\StatusEnumsManagement::APPROVED->value),

            Hidden::make('created_by')
                ->default(Auth::id())
                ->label(__('admin/dashboard.event.created_by')),

            Forms\Components\Hidden::make('sort')
                ->label(__('admin/dashboard.event.sort'))
                ->default(function () {
                    $currentSortValue = Event::max('sort');
                    return ($currentSortValue ?? 0) + 1;
                }),

            CKEditor::make('details')
                ->label(__('admin/dashboard.event.details'))

                ->columnSpan('full'),

            FileUpload::make('attachments')
                ->directory('storage/cgo/events/attachments/temp')
                ->imageEditor()
                ->preserveFilenames()
                ->columnSpan('full')
                ->reactive()
                ->optimize('webp'),
        ]);

    }

    public static function table(Table $table): Table
    {

        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->orderByRaw('COALESCE(is_main_event, false) DESC')
                    ->orderByDesc('created_at');
            })
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label(__('admin/dashboard.event.date'))->date("Y-m-d")
                    ->wrap(),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->label(__('admin/dashboard.event.title_table'))
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('admin/dashboard.event.author'))
                    ->wrap(),

                Tables\Columns\TextColumn::make('event_type')
                    ->label(__('admin/dashboard.event.event_type'))
                    ->formatStateUsing(function ($record) {
                        return getCodeNameByCodeId('event_type', $record->event_type);
                    })
                    ->wrap(),

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
                        __('admin/status.approved') : ($record->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value ?
                            __('admin/status.non_approval') : __('admin/status.pending_approval')))
                    ->formatStateUsing(function ($state) {
                        if ($state === __('admin/status.approved')) {
                            return "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>";
                        }
                        return "<span style='font-size:12px;color: #5a5252; background-color: #d3d3d3; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>$state</span>";
                    })
                    ->html(),


//                    Tables\Columns\TextColumn::make('show_on_homepage')
//                    ->label(__('admin/dashboard.event.show_on_home_page'))
//                    ->formatStateUsing(function ($record) {
//                        $total = $record->query()->where('show_on_homepage', true)->count();
//                        $adminCount = $record->query()
//                            ->where('show_on_homepage', true)
//                            ->where('system', 'admin')
//                            ->count();
//                        $isShown = $record->show_on_homepage;
//
//                        return "<span style='font-size:12px; " .
//                               ($isShown ? "color: #4984F6; background-color: #F2F9FF;" : "color: #666; background-color: #f5f5f5;") .
//                               " padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>" .
//                               ($isShown ? "Showing" : "Not showing") .
//                               "</span>";
//                    })
//                    ->html()
//                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
                    Tables\Columns\ToggleColumn::make('is_main_event')
                        ->label(trans('general.Main Event'))
                        ->alignCenter()
                        ->disabled(fn ($record) => $record->status === \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value),
            ])
            ->searchPlaceholder('Title')
            ->filters([
//                Tables\Filters\Filter::make('show_on_homepage')
//                    ->label('Show on Homepage')
//                    ->query(fn($query) => $query->where('show_on_homepage', true))
//                    ->toggle(),
                Tables\Filters\Filter::make('is_main_event')
                    ->label('Main event')
                    ->query(fn($query) => $query->where('is_main_event', true))
                    ->toggle(),
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
//                Tables\Actions\Action::make('toggle_homepage')
//                    ->label(fn($record) => $record->show_on_homepage ? 'Remove from Homepage' : 'Enable showing on Homepage')
//                    ->action(function ($record) {
//                        // Kiểm tra nếu đang thêm vào homepage
//                        if (!$record->show_on_homepage) {
//                            // Đếm tổng số record đang show trên homepage
//                            $totalCount = $record->query()->where('show_on_homepage', true)->count();
//
//                            // Kiểm tra điều kiện status = 2
//                            if ($record->status != 2) {
//                                Notification::make()
//                                    ->warning()
//                                    ->title('Cannot add to homepage')
//                                    ->body('Only approved events can be shown on homepage.')
//                                    ->send();
//                                return;
//                            }
//
//                            // Kiểm tra số lượng tối đa
//                            if ($totalCount >= 4) {
//                                Notification::make()
//                                    ->warning()
//                                    ->title('Cannot add to homepage')
//                                    ->body('Maximum of 4 items can be shown on homepage. Please remove some items first.')
//                                    ->send();
//                                return;
//                            }
//                        }
//
//                        $record->show_on_homepage = !$record->show_on_homepage;
//                        $record->save();
//
//                        Notification::make()
//                            ->success()
//                            ->title($record->show_on_homepage ? 'Added to homepage' : 'Removed from homepage')
//                            ->send();
//                    })
////                    ->icon(fn($record) => $record->show_on_homepage ? 'heroicon-o-x-mark' : 'heroicon-o-check')
//                    ->icon(fn($record) => $record->show_on_homepage ? 'heroicon-o-x-mark' : '')
//                    ->color(fn($record) => $record->show_on_homepage ? 'danger' : 'success')
////                    ->visible(fn($record) => $record->status == 2)
//                    ->visible(fn($record) => $record->status == 2 && auth('admin')->user()->hasRole('super_admin')),

                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->created_by === auth()->id() && $record->system === 'admin' && auth('admin')->user()->hasRole('super_admin')),

//                    ->visible(fn($record) => $record->created_by === auth()->id() && $record->system === 'admin'),
                Tables\Actions\ViewAction::make()->color('primary'),
            ])->paginated([10, 25, 50, 100])
//            ->reorderable('sort', auth('admin')->user()->hasRole('super_admin'))
//            ->reorderRecordsTriggerAction(
//                fn (Action $action, bool $isReordering) => $action
//                    ->button()
//                    ->label($isReordering ? __('Finish reordering position showing on homepage') : __('Reordering position showing on homepage'))
//                    ->icon($isReordering ? 'heroicon-o-check' : 'heroicon-o-bars-3')
//                    ->color($isReordering ? 'success' : 'primary')
//            )
            ->actionsColumnLabel(__('cgo.action'))
            ->actionsAlignment(Alignment::Between->value)
            ->authorizeReorder()
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEventLists::route('/'),
            'create' => Pages\CreateEventList::route('/create'),
            'view' => Pages\ViewEventList::route('/{record}'),
            'edit' => Pages\EditEventList::route('/{record}/edit'),
        ];
    }
}
