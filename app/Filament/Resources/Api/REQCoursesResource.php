<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\REQCoursesResource\Pages;
use App\Filament\Resources\Api\REQCoursesResource\RelationManagers;
use App\Models\ReqCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class REQCoursesResource extends Resource
{
    protected static ?string $model = ReqCourse::class;
    protected static ?string $modelLabel = 'REQ Course';

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
            Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.regcourse.index'))
                ->rowIndex()
                ->alignCenter(),
        
            TextColumn::make('institute_reg_no')
                ->label(__('admin/dashboard.regcourse.institute_reg_no'))
                ->sortable(),
        
            TextColumn::make('institute_name')
                ->label(__('admin/dashboard.regcourse.institute_name'))
                ->sortable()
                ->searchable(),
        
            TextColumn::make('district_code')
                ->label(__('admin/dashboard.regcourse.district_code')),
        
            TextColumn::make('course_id')
                ->label(__('admin/dashboard.regcourse.course_id'))
                ->sortable(),
        
            TextColumn::make('course_name')
                ->label(__('admin/dashboard.regcourse.course_name'))
                ->sortable()
                ->searchable(),
        
            TextColumn::make('course_duration')
                ->label(__('admin/dashboard.regcourse.course_duration')),
        
            TextColumn::make('course_mode')
                ->label(__('admin/dashboard.regcourse.course_mode')),
        
            TextColumn::make('course_medium')
                ->label(__('admin/dashboard.regcourse.course_medium')),
        
            TextColumn::make('entry_qualification')
                ->label(__('admin/dashboard.regcourse.entry_qualification'))
                ->sortable(),
        ])
        ->paginated([10, 25, 50, 100])
        ->searchPlaceholder('Course name')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListREQCourses::route('/'),
            // 'create' => Pages\CreateREQCourses::route('/create'),
            // 'view' => Pages\ViewREQCourses::route('/{record}'),
            // 'edit' => Pages\EditREQCourses::route('/{record}/edit'),
        ];
    }
}
