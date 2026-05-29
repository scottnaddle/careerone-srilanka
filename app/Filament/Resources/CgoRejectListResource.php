<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CgoRejectListResource\Pages;
use App\Filament\Resources\CgoRejectListResource\RelationManagers;
use App\Models\CgoUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;

class CgoRejectListResource extends Resource
{
    protected static ?string $model = CgoUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'CGO Refusal';

    public static $totalCgo;
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
        $query=$searchService->searchCgo([
            'search' => request()->query('search', null),
            'TVET_type' => request()->query('TVET_type', null),
            'institute' => request()->query('institute', null),
            'no_check_verify'=>true,
            'check_reject'=>true,
            'date'=> request()->query('datePicker', null),
            'search_time' => request()->query('search-time', null),
        ]);
        self::$totalCgo =$query->count();
        return $table
        ->query(
            $query
        )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('institute.name')
                    ->label('Institution')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fullName')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->fullName ?? 'N/A';
                    })->searchable([
                        'first_name', 'last_name'
                    ])
                   
                    ,

                Tables\Columns\TextColumn::make('approval')
                    ->label('Approval')
                    ->getStateUsing(function ($record) {
                        return $record->isFullyVerified() ? 'Verified' : 'Reject';
                    })
                    ->formatStateUsing(function ($state) {
                        if ($state === 'Verified') {
                            return "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>";
                        }
                        return "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>$state</span>";
                    })
                    ->html(),
            ])
            ->filters([
                // Define filters if necessary
            ])
            ->actions([
                // Define actions if necessary
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth('admin')->user();
                // if ($user->hasRole('SuperAdmin')) {
                //     return $query;
                // } else {
                //     return $query->where('institute_id', $user->institute_id);
                // }
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return __("Cgo Reject");
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCgoRejectLists::route('/'),
            'create' => Pages\CreateCgoRejectList::route('/create'),
            'view' => Pages\ViewCgoRejectList::route('/{record}'),
            'edit' => Pages\EditCgoRejectList::route('/{record}/edit'),
        ];
    }
}
