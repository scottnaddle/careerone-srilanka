<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselingListResource\Pages;
use App\Models\CgoCounseling;
use App\Models\District;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use App\Services\Admin\SearchComponentAdminService;

class CounselingListResource extends Resource
{
    protected static ?string $model = CgoCounseling::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Career Guidance';

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
        $customQuery = $searchService->searchCounseling([
            'search' => request()->query('search', null),
        ]);

        return $table
            ->query($customQuery)
            ->columns([
                TextColumn::make('index')
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
                        }
                        return $record->traineeUser?->fullName;
                    }),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('date')
                            ->label('Created Date')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('created_at', $data['date']);
                        }
                    }),
                Tables\Filters\Filter::make('updated_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('date')
                            ->label('Updated Date')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('updated_at', $data['date']);
                        }
                    }),
            ])
            ->paginated([10, 25, 50, 100])
            ->striped()
            ->filters([
                Tables\Filters\SelectFilter::make('district')
                    ->label('District')
                    ->options(District::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->query(function ($query, $data) {
                        if (!empty($data['value'])) {
                            $query->where('institutes.dist_id', $data['value']);
                        }
                    }),
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
                    ->searchable()
                    ->query(function ($query, $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('institute.tvetType', function ($q) use ($data) {
                                $q->where('head_office_code', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCounselingLists::route('/'),
            'view' => Pages\ViewCounselingList::route('/{record}'),
        ];
    }
}
