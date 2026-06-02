<?php

namespace App\Filament\Resources\Information;

use App\Filament\Resources\Information\QAResource\Pages;
use App\Filament\Resources\Information\QAResource\RelationManagers;
use App\Models\Information\QA;
use App\Models\QNA;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;

class QAResource extends Resource
{
    protected static ?string $model = QNA::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countQNA;
    protected static ?string $modelLabel = 'Q&A';
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
        $customQuery=$searchService->searchQNA([
            'search' => request()->query('search', null),
            'no_check_verify'=>true,
            'search_time' => request()->query('search-time', null),
        ]);
        self::$countQNA=$customQuery->count();
        return $table
        ->defaultSort('created_at', 'desc')
        ->query(
            $customQuery
        )
        ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),
                Tables\Columns\TextColumn::make('title')
                //->label( Tables\Columns\TextColumn::make('index')
                //->label(__('admin/dashboard.content.no'))
                //->rowIndex()
                //->alignCenter(),)
                ->getStateUsing(function($record){
                    return $record->title .'('.$record->replies->count().')';
                })
                ->sortable()->searchable()->wrap(),
                Tables\Columns\TextColumn::make('author.full_name')
                ->limit(50)
                ->label(__('admin/dashboard.qna.owner'))->wrap()
                ,
                Tables\Columns\TextColumn::make('created_at')
                ->label(__('admin/dashboard.qna.registration_date'))
                ->sortable()->wrap(),
                Tables\Columns\TextColumn::make('approval')
                ->label('Approval')
                ->getStateUsing(function ($record) {
                    return $record->status ? 'Approved' : 'Non-Approved';
                })->wrap(),
                Tables\Columns\TextColumn::make('approval')
                ->label(__('admin/dashboard.qna.action'))
                ->getStateUsing(function ($record) {
                    return $record->status ? 'Approved' : 'Non-Approved';
                })
                ->formatStateUsing(function ($state) {
                    if ($state === 'Verified') {
                        return "<span style='display:inline-block; font-size:12px; color: white; background-color: #3B82F6; padding: 0.5rem 1rem; border-radius: 1rem; font-weight:600;'>View more</span>";
                    }
                    return "<span style='display:inline-block; font-size:12px; color: white; background-color: #3B82F6; padding: 0.5rem 1rem; border-radius: 1rem; font-weight:600;'>Reply</span>";
                })
                ->html()
                ->visible(fn () => auth('admin')->user()->hasRole('super_admin'))

        ])->searchPlaceholder('Title')
            ->filters([
                //
            ])
            ->paginated([10, 25, 50, 100])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

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
            'index' => Pages\ListQAS::route('/'),
            'create' => Pages\CreateQA::route('/create'),
            'view' => Pages\ViewQA::route('/{record}'),
            'edit' => Pages\EditQA::route('/{record}/edit'),
        ];
    }
}
