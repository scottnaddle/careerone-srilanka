<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedCGODetailResource\Pages;
use App\Filament\Resources\ApprovedCGODetailResource\RelationManagers;
use App\Models\CgoUser;
use App\Models\Institute;
use App\Models\TvetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovedCGODetailResource extends Resource
{
    protected static ?string $model = CgoUser::class;
    protected static ?string $modelLabel = 'Approved CGO Details';
//    protected static ?string $breadcrumb = 'Membership > CGO > Approved CGO Details';
    protected static ?string $navigationGroup = 'Membership';
    protected static ?string $navigationLabel = 'Approved CGO Details';
    protected static ?string $navigationParentItem = 'CGO';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string {
        return trans('menu.approved_cgo_details');
    }

    public static $totalCgo;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    public static function getEloquentQuery(): Builder {

        return CgoUser::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Name')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('institute.name')
                    ->label(__('admin/dashboard.cgo.institute'))
                    ->sortable()->limit('50')->wrap(),
                Tables\Columns\TextColumn::make('district.name')->label(trans('trainee.job_support.company.table.label.district')) ->sortable()->wrap(),
                Tables\Columns\TextColumn::make('fullName')
                    ->label(__('admin/dashboard.cgo.name'))
                    ->getStateUsing(fn($record) => $record->fullName ?? 'N/A')
                    ->searchable(['first_name', 'last_name'])->wrap(),
//                Tables\Columns\TextColumn::make('counseling')
//                    ->getStateUsing(fn($record) => $record->counselings->count())
//                    ->label(__('admin/dashboard.cgo.guidance'))
//                    ->alignCenter(),
//
//                Tables\Columns\TextColumn::make('cancel')->label(__('admin/dashboard.cgo.cancel'))
//                    ->getStateUsing(fn($record) => $record->countCancelCounseling->count() ?? 'N/A')->alignCenter(),
//                Tables\Columns\TextColumn::make('event')->label(__('admin/dashboard.cgo.event'))
//                    ->getStateUsing(fn($record) => $record->events->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('content')->label(__('admin/dashboard.cgo.content'))
//                    ->getStateUsing(fn($record) => $record->contents->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('reply')->label(__('admin/dashboard.cgo.reply'))
//                    ->getStateUsing(fn($record) => $record->qnaAnswes->count() ?? 'N/A') ->alignCenter(),
                // Cột counseling
                Tables\Columns\TextColumn::make('counseling')
                    ->label(__('admin/dashboard.cgo.guidance'))
                    ->getStateUsing(fn($record) => $record->counselings->count())
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('counselings')->orderBy('counselings_count', $direction);
                    }),

                // Cột cancel
                Tables\Columns\TextColumn::make('cancel')
                    ->label(__('admin/dashboard.cgo.cancel'))
                    ->getStateUsing(fn($record) => $record->countCancelCounseling->count() ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('countCancelCounseling')->orderBy('count_cancel_counseling_count', $direction);
                    }),

                // Cột event
                Tables\Columns\TextColumn::make('event')
                    ->label(__('admin/dashboard.cgo.event'))
                    ->getStateUsing(fn($record) => $record->events->count() ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('events')->orderBy('events_count', $direction);
                    }),

                // Cột content
                Tables\Columns\TextColumn::make('content')
                    ->label(__('admin/dashboard.cgo.content'))
                    ->getStateUsing(fn($record) => $record->contents->count() ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('contents')->orderBy('contents_count', $direction);
                    }),

                // Cột reply
                Tables\Columns\TextColumn::make('reply')
                    ->label(__('admin/dashboard.cgo.reply'))
                    ->getStateUsing(fn($record) => $record->qnaAnswes->count() ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('qnaAnswes')->orderBy('qna_answes_count', $direction);
                    }),
            ])->paginated([10, 25, 50, 100])
            ->actions([
            ])
            ->filters([
                Tables\Filters\Filter::make('tvet_type')
                    ->form([
                        Forms\Components\Select::make('tvet_type')
                            ->label('TVET')
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
                                    return Institute::where('institute_head_office', $tvetCode)->orderBy('name', 'asc')
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
                            $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])->orderBy('name', 'asc')
                                ->pluck('id')
                                ->toArray();
                            $query->whereIn('institute_id', $instituteIds);
                        }
                        if (!empty($data['institute_select'])) {
                            $query->where('institute_id', $data['institute_select']);
                        }
                    }),
            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // Example of user-based query modification
                // $user = auth('admin')->user();
                // if (!$user->hasRole('SuperAdmin')) {
                //     $query->where('institute_id', $user->institute_id);
                // }
            });
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
            'index' => Pages\ListApprovedCGODetails::route('/'),
//            'create' => Pages\CreateApprovedCGODetail::route('/create'),
//            'edit' => Pages\EditApprovedCGODetail::route('/{record}/edit'),
        ];
    }
}
