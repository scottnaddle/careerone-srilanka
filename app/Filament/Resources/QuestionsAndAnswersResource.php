<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionsAndAnswersResource\Pages;
use App\Filament\Resources\QuestionsAndAnswersResource\RelationManagers;
use App\Models\AdminUser;
// use App\Models\QuestionsAndAnswers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsAndAnswersResource extends Resource
{
    protected static ?string $model = AdminUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
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
            'index' => Pages\ListQuestionsAndAnswers::route('/'),
            'create' => Pages\CreateQuestionsAndAnswers::route('/create'),
            'edit' => Pages\EditQuestionsAndAnswers::route('/{record}/edit'),
            // 'delete' => Pages\
        ];
    }
}
