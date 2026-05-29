<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselingListResource\Pages;
use App\Filament\Resources\CounselingListResource\RelationManagers;
use App\Models\CgoCounseling;
use App\Models\CounselingList;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
class CounselingListResource extends Resource
{
    protected static ?string $model = CgoCounseling::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countContentList;
    protected static ?string $modelLabel = 'Career Guidance';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
        $customQuery=$searchService->searchCounseling([
            'search' => request()->query('search', null),
            'district'=>request()->query('district',null),
            'search_time' => request()->query('search-time', null),
        ]);
        self::$countContentList= $customQuery->count();
        return $table
        ->query(
            $customQuery
        )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                TextColumn::make('counseling_type')
                ->sortable()
                ->label(__('admin/dashboard.counseling.detail.type'))
                ->getStateUsing(function ($record) {
                    return getCodeNameByCodeId('counselling_type', $record->counseling_type) ?? 'N/A';
                }),
                TextColumn::make('counseling_field_id')
                ->label(__('admin/dashboard.counseling.detail.counseling_field'))
                ->getStateUsing(function ($record) {
                    return getCodeNameByCodeId('counselling_field', $record->counseling_field_id) ?? 'N/A';
                })
                ->sortable(),
                TextColumn::make('title')
                ->label(__('admin/dashboard.counseling.detail.title'))
                ->searchable()
                ->limit(50)
                ->sortable(),
                TextColumn::make('registration_date')
                ->label(__('admin/dashboard.counseling.detail.registraton_date'))

                ->sortable(),
                TextColumn::make('available_time')
                ->label(__('admin/dashboard.counseling.detail.counseling_date'))
                ->sortable(),
                TextColumn::make('institute.name')
                ->label(__('admin/dashboard.counseling.detail.trainee_institute'))
                ->sortable(),
                TextColumn::make('trainee_name.full_name')
                ->label(__('admin/dashboard.counseling.detail.trainee_name'))
                ->getStateUsing(function ($record) {
                    if ($record->trainee_id == null) {
                        return $record->trainee_offline_firstname . ' ' . $record->trainee_offline_lastname;
                    }else{
                        return $record->traineeUser?->fullName;
                    }
                }),


            ])->paginated([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->label('District')
                    ->options(District::pluck('name', 'id')->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))
                    ->options(
                        \App\Models\TvetType::query()
                            ->orderBy('head_office_name')
                            ->get()
                            ->mapWithKeys(fn ($item) => [
                                $item->head_office_code => $item->head_office_name . ' (' . $item->head_office_code . ')'
                            ])
                            ->toArray()
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('institute.tvetType', function ($q) use ($data) {
                                $q->where('head_office_code', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([

            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([

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
            'index' => Pages\ListCounselingLists::route('/'),
            'view' => Pages\ViewCounselingList::route('/{record}'),
        ];
    }
}
