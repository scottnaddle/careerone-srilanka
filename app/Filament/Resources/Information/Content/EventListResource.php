<?php

namespace App\Filament\Resources\Information\Content;

use App\Filament\Resources\Information\Content\EventListResource\Pages;
use App\Filament\Resources\Information\Content\EventListResource\RelationManagers;
use App\Models\Event;
use App\Models\CgoUser;
use App\Models\Institute;
use App\Models\TvetType;
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
                            ->disk('public')
                            ->directory('cgo/events/thumbnails/temp')
                            ->imageEditor()
                            ->required()
                            ->preserveFilenames()
                            ->columnSpan('w-1/2')
                            ->optimize('webp'),

                        TextInput::make('place')
                            ->label(__('admin/dashboard.event.place'))
                            ->columnSpan('w-2/3'),
                    ]),

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
        $user = auth('admin')->user();
        $isSuperAdmin = $user->hasRole('super_admin');
        $userTvetType = $user->tvet_type;

        $filters = [];

        if ($isSuperAdmin) {
            // Filter cho super_admin: có thể chọn TVET và Institute
            $filters[] = Tables\Filters\Filter::make('tvet_type_filter')
                ->form([
                    Forms\Components\Select::make('tvet_type')
                        ->label('Head Office')
                        ->options(TvetType::all()->pluck('head_office_name', 'head_office_code'))
                        ->preload()
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('institute_select', null);
                        }),

                    Forms\Components\Select::make('institute_select')
                        ->label('Institute')
                        ->options(function ($get) {
                            $tvetCode = $get('tvet_type');
                            if ($tvetCode) {
                                return Institute::where('institute_head_office', $tvetCode)
                                    ->orderBy('name', 'asc')
                                    ->pluck('name', 'id');
                            }
                            return [];
                        })
                        ->preload()
                        ->searchable()
                        ->visible(function ($get) {
                            return !empty($get('tvet_type'));
                        }),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['tvet_type'])) {
                        $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])
                            ->pluck('id')
                            ->toArray();
                        $query->whereHas('cgoUsers', function ($q) use ($instituteIds) {
                            $q->whereIn('institute_id', $instituteIds);
                        });
                    }
                    if (!empty($data['institute_select'])) {
                        $query->whereHas('cgoUsers', function ($q) use ($data) {
                            $q->where('institute_id', $data['institute_select']);
                        });
                    }
                });
        } else {
            // Filter cho admin thường: chỉ hiển thị institute thuộc tvet_type của họ
            if ($userTvetType) {
                $instituteOptions = Institute::where('institute_head_office', $userTvetType)
                    ->orderBy('name', 'asc')
                    ->pluck('name', 'id')
                    ->toArray();

                $filters[] = Tables\Filters\Filter::make('institute_filter')
                    ->form([
                        Forms\Components\Select::make('institute_select')
                            ->label('Institute')
                            ->options($instituteOptions)
                            ->preload()
                            ->searchable()
                            ->placeholder('All Institutes'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['institute_select'])) {
                            $query->whereHas('cgoUsers', function ($q) use ($data) {
                                $q->where('institute_id', $data['institute_select']);
                            });
                        }
                    });
            }
        }

        // Thêm các filter cơ bản
        $filters[] = Tables\Filters\Filter::make('is_main_event')
            ->label('Main event')
            ->query(fn($query) => $query->where('is_main_event', true))
            ->toggle();

        $filters[] = Tables\Filters\SelectFilter::make('event_type')
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
            ->column('event_type');

        $filters[] = Tables\Filters\SelectFilter::make('system')
            ->label('Select member')
            ->options([
                'cgo' => 'CGO',
                'company' => 'Company',
                'admin' => 'Admin'
            ])
            ->placeholder('All Member')
            ->column('system');

        $filters[] = Tables\Filters\SelectFilter::make('status')
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
            ->column('status');

        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth('admin')->user();
                $isSuperAdmin = $user->hasRole('super_admin');

                // Nếu không phải super_admin, chỉ hiển thị event được tạo bởi CGO thuộc institute của user
                if (!$isSuperAdmin) {
                    $userTvetType = $user->tvet_type;

                    if ($userTvetType) {
                        // Lấy tất cả institute thuộc tvet_type của user
                        $instituteIds = Institute::where('institute_head_office', $userTvetType)
                            ->pluck('id')
                            ->toArray();

                        // Chỉ hiển thị event có created_by là CGO user thuộc các institute đó
                        // và system là 'cgo'
                        $query->where('system', 'cgo')
                            ->whereHas('cgoUsers', function ($q) use ($instituteIds) {
                                $q->whereIn('institute_id', $instituteIds);
                            });
                    } else {
                        // Nếu user không có tvet_type, không hiển thị gì
                        $query->whereRaw('1 = 0');
                    }
                }

                // Sắp xếp: main event lên đầu, sau đó mới đến created_at
                return $query->orderByRaw('COALESCE(is_main_event, false) DESC')
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

                Tables\Columns\ToggleColumn::make('is_main_event')
                    ->label(trans('general.Main Event'))
                    ->alignCenter()->visible(fn () => auth('admin')->user()->hasRole('super_admin'))
                    ->disabled(fn ($record) => $record->status === \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value),
            ])
            ->searchPlaceholder('Title')
            ->filters($filters)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->created_by === auth()->id() && $record->system === 'admin' && auth('admin')->user()->hasRole('super_admin')),
                Tables\Actions\ViewAction::make()->color('primary'),
            ])
            ->paginated([10, 25, 50, 100])
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
