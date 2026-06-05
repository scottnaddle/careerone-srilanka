<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\NVQCoursesResource\Pages;
use App\Filament\Resources\Api\NVQCoursesResource\RelationManagers;
use App\Models\NvqCourses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;
use App\Services\BreadcrumbService;

class NVQCoursesResource extends Resource
{
    protected static ?string $model = NvqCourses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'NVQ Course';
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
                ->label(__('admin/dashboard.nvqCourse.index'))
                ->rowIndex()
                ->alignCenter(),
        
            TextColumn::make('course_id')
                ->label(__('admin/dashboard.nvqCourse.course_id'))
                ->sortable()
                ->searchable(),
        
            TextColumn::make('course_name')
                ->label(__('admin/dashboard.nvqCourse.course_name'))
                ->sortable()
                ->searchable(),
        
            TextColumn::make('level')
                ->label(__('admin/dashboard.nvqCourse.level'))
                ->sortable(),
        
            TextColumn::make('ncs_code')
                ->label(__('admin/dashboard.nvqCourse.ncs_code'))
                ->sortable(),
        
            TextColumn::make('ncs_name')
                ->label(__('admin/dashboard.nvqCourse.ncs_name'))
                ->sortable(),
        
            TextColumn::make('reg_no')
                ->label(__('admin/dashboard.nvqCourse.reg_no'))
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListNVQCourses::route('/'),
            // 'create' => Pages\CreateNVQCourses::route('/create'),
            // 'view' => Pages\ViewNVQCourses::route('/{record}'),
            // 'edit' => Pages\EditNVQCourses::route('/{record}/edit'),
        ];
    }
}
