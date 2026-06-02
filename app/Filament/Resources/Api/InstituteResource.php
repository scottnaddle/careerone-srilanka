<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\InstituteResource\Pages;
use App\Filament\Resources\Api\InstituteResource\RelationManagers;
use App\Models\Institute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class InstituteResource extends Resource
{
    protected static ?string $model = Institute::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()

                ->maxLength(255),

//            Forms\Components\TextInput::make('detail')
//                ->nullable()
//                ->maxLength(255),

            Forms\Components\TextInput::make('phone')
                ->required()
                ->maxLength(255),

//            Forms\Components\TextInput::make('fax')
//                ->nullable()
//                ->maxLength(255),
//
//            Select::make('prov_id')
//                ->label('Province')
//                ->options(function () {
//                    return \App\Models\Province::all()->pluck('name', 'id')->toArray();
//                })
//                ->nullable(),

            Select::make('dist_id')
                ->label('District')
                ->options(function () {
                    return \App\Models\District::all()->pluck('name', 'id')->toArray();
                })
                ->nullable(),

            DatePicker::make('valid_form')
                ->nullable(),

            DatePicker::make('valid_to')
                ->nullable(),

            Forms\Components\TextInput::make('created_by')
                ->required()
                ->default(Auth::id())
                ->disabled()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.institute.index'))
                ->rowIndex()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('name')
                ->label(__('admin/dashboard.institute.name'))
                ->sortable()
                ->limit(50)
                ->searchable()
                ->wrap(),

//            Tables\Columns\TextColumn::make('detail')
//                ->label(__('admin/dashboard.institute.detail')),

            Tables\Columns\TextColumn::make('phone')
                ->label(__('admin/dashboard.institute.phone'))
                ->wrap(),

//            Tables\Columns\TextColumn::make('fax')
//                ->label(__('admin/dashboard.institute.fax')),
//
//            Tables\Columns\TextColumn::make('prov_id')
//                ->label(__('admin/dashboard.institute.prov_id')),

            Tables\Columns\TextColumn::make('dist_id')
                ->label(__('admin/dashboard.institute.dist_id'))
                ->wrap(),

            Tables\Columns\TextColumn::make('ds_id')
                ->label(__('admin/dashboard.institute.ds_id'))
                ->wrap(),

            Tables\Columns\TextColumn::make('valid_form')
                ->label(__('admin/dashboard.institute.valid_form'))
                ->wrap(),

            Tables\Columns\TextColumn::make('valid_to')
                ->label(__('admin/dashboard.institute.valid_to'))
                ->wrap(),

            Tables\Columns\TextColumn::make('reg_no')
                ->label(__('admin/dashboard.institute.reg_no'))
                ->wrap(),

            Tables\Columns\TextColumn::make('ownership')
                ->label(__('admin/dashboard.institute.ownership'))
                ->wrap(),

            Tables\Columns\TextColumn::make('active_status')
                ->label(__('admin/dashboard.institute.active_status'))
                ->wrap(),

            Tables\Columns\TextColumn::make('institute_head_office')
                ->label(__('admin/dashboard.institute.institute_head_office'))
                ->wrap(),

        ])
        ->paginated([10, 25, 50, 100])
        ->searchPlaceholder('Name')
        ->filters([
            //
        ])
        ->actions([
            // Tables\Actions\EditAction::make(),
            // Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListInstitutes::route('/'),
            // 'create' => Pages\CreateInstitute::route('/create'),
            // 'view' => Pages\ViewInstitute::route('/{record}'),
            // 'edit' => Pages\EditInstitute::route('/{record}/edit'),
        ];
    }
}
