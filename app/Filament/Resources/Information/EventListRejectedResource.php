<?php

namespace App\Filament\Resources\Information;

use App\Filament\Resources\Information\EventListRejectedResource\Pages;
use App\Filament\Resources\Information\EventListRejectedResource\RelationManagers;
use App\Models\Event;
use App\Models\Information\EventListRejected;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;

class EventListRejectedResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countEvnet;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'no_check_verify' => true,
            'check_reject'=>true,
            'search_time' => request()->query('search-time', null),
        ]);

        self::$countEvnet = $customQuery->count();

        return $table
            ->query($customQuery)
            ->columns([
                Tables\Columns\TextColumn::make('No.')
                    ->label('No.')
                    ->getStateUsing(fn($rowLoop) => $rowLoop->iteration)
                    ->formatStateUsing(function ($state, $rowLoop) {
                        return $rowLoop->iteration <= 4 ? "<span class='highlight'>$state</span>" : $state;
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('Date')
                    ->formatStateUsing(function ($state, $rowLoop) {
                        return $rowLoop->iteration <= 4 ? "<span class='highlight'>$state</span>" : $state;
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()

                    ->label('Title')
                    ->limit(50)
                    ->formatStateUsing(function ($state, $rowLoop) {
                        return $rowLoop->iteration <= 4 ? "<span class='highlight'>$state</span>" : $state;
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Author')
                    ->formatStateUsing(function ($state, $rowLoop) {
                        return $rowLoop->iteration <= 4 ? "<span class='highlight'>$state</span>" : $state;
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('event_type')
                    ->label('Event Type')
                    ->html()
                    ->formatStateUsing(function ($record) {
                        return getCodeNameByCodeId('event_type', $record->event_type);
                    }),

                Tables\Columns\TextColumn::make('system')
                    ->sortable()
                    ->label('Member')->wrap(),

                Tables\Columns\TextColumn::make('approval')
                    ->label('Approval')
                    ->getStateUsing(fn($record) => $record->status == 2 ? 'Approved' : ($record->status == 1 ? 'Non-Approved' : 'Pending approval'))
                    ->formatStateUsing(function ($state) {
                        if ($state === 'Approved') {
                            return "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Action ></span>";
                        }
                        return  "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Action ></span>";
                    })
                    ->html(),
            ])->searchPlaceholder('Title')
            ->paginated([10, 25, 50, 100])
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
                // Tables\Actions\EditAction::make()
                //     ->visible(fn($record) => $record->created_by === auth()->id() && $record->system === 'admin'),

            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListEventListRejecteds::route('/'),
            'create' => Pages\CreateEventListRejected::route('/create'),
            'view' => Pages\ViewEventListRejected::route('/{record}'),
            'edit' => Pages\EditEventListRejected::route('/{record}/edit'),
        ];
    }
}
