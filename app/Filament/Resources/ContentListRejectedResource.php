<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentListRejectedResource\Pages;
use App\Filament\Resources\ContentListRejectedResource\RelationManagers;
use App\Models\Content;
use App\Models\ContentListRejected;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;

class ContentListRejectedResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countContentApprovalList;



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
        $customQuery=$searchService->searchContent([
            'search' => request()->query('search', null),
            'type'=>true,
            'member' => request()->query('member', null),
            'search_time' => request()->query('search-time', null),
            'check_reject'=>true,
        ]);
        self::$countContentApprovalList=$customQuery->count();
        return $table
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
                    ->label('Date'),
                    Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->limit(50)
                    ->searchable()
                    ->label('Title'),
                    Tables\Columns\TextColumn::make('author')
                    ->searchable()
                    ->sortable()
                    ->label('Author'),
                    Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->label('Type'),
                    Tables\Columns\TextColumn::make('system')
                    ->sortable()
                    ->label('Member'),
                    Tables\Columns\TextColumn::make('approval')
                    ->label('Approval')
                    ->getStateUsing(function ($record) {
                        return $record->status ? 'Verified' : 'Not Verified';
                    })
                    ->formatStateUsing(function ($state) {
                        if ($state === 'Verified') {
                            return "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Action ></span>";
                        }
                        return  "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Action ></span>";
                    })
                    ->html()

            ])
            ->filters([
                //
            ])->paginated([10, 25, 50, 100])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListContentListRejecteds::route('/'),
            'create' => Pages\CreateContentListRejected::route('/create'),
            'view' => Pages\ViewContentListRejected::route('/{record}'),
            'edit' => Pages\EditContentListRejected::route('/{record}/edit'),
            'index-video' => Pages\ListContentVideoRejected::route('/video/view'),
        ];
    }
}
