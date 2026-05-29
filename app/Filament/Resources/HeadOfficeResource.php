<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeadOfficeResource\Pages;
use App\Filament\Resources\HeadOfficeResource\RelationManagers;
use App\Models\HeadOffice;
use App\Models\HeadOfficeModel;
use App\Models\TvetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeadOfficeResource extends Resource
{
//    protected static ?string $model = HeadOfficeModel::class;
    protected static ?string $model = TvetType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    public function getTitle(): string
    {
        return 'Head Office';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                TextColumn::make('head_office_code')
                ->label(__('admin/dashboard.head_office.head_office_code'))
                ->sortable()
                ->searchable(),
                TextColumn::make('head_office_name')
                ->label(__('admin/dashboard.head_office.head_office_name'))
                ->searchable()
                ->sortable()
            ])->searchPlaceholder('Head office name')->paginated([10, 25, 50, 100])
//            ->defaultSort('updated_at', 'desc')
//            ->reorderable('updated_at')
            ->filters([
                //
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
            'index' => Pages\ListHeadOffices::route('/'),
            // 'create' => Pages\CreateHeadOffice::route('/create'),
            // 'view' => Pages\ViewHeadOffice::route('/{record}'),
            // 'edit' => Pages\EditHeadOffice::route('/{record}/edit'),
        ];
    }
}
