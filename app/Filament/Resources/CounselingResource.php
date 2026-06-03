<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselingResource\Pages;
use App\Filament\Resources\CounselingResource\RelationManagers;
use App\Models\CgoCounseling;
use App\Models\CounselingField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CounselingResource extends Resource
{
    protected static ?string $model = CgoCounseling::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
        ])
        ->filters([
            // Define any filters if needed
        ])
        ->actions([
            // Define any actions if needed
        ])->paginated([10, 25, 50, 100])
        ->defaultSort('updated_at', 'desc')
        ->reorderable('updated_at')
        ->bulkActions([
            // Define any bulk actions if needed
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
            'index' => Pages\ListCounselings::route('/'),
            'create' => Pages\CreateCounseling::route('/create'),
            'edit' => Pages\EditCounseling::route('/{record}/edit'),
        ];
    }
}
