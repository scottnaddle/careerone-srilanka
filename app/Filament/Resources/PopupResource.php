<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\CKEditor;
use App\Filament\Resources\PopupResource\Pages;
use App\Filament\Resources\PopupResource\RelationManagers;
use App\Models\Popup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\{TextInput, Textarea, FileUpload, DateTimePicker, Select};
use Filament\Tables\Columns\{TextColumn, ImageColumn, BadgeColumn, DateTimeColumn};

class PopupResource extends Resource
{
    protected static ?string $model = Popup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('popup_name')->label(trans('admin/dashboard.popup_name'))->required()->columnSpanFull(),
                Forms\Components\Grid::make(3)->schema([
                    TextInput::make('title')->nullable()->label(trans('admin/dashboard.title_en'))->columnSpan('1/3'),
                    TextInput::make('title_sn')->nullable()->label(trans('admin/dashboard.title_sn'))->columnSpan('1/3'),
                    TextInput::make('title_tm')->nullable()->label(trans('admin/dashboard.title_tm'))->columnSpan('1/3'),
                ]),
                FileUpload::make('image')
                    ->label(trans('admin/dashboard.banner.image_section'))
                    ->image()
                    ->directory('popups')
                    ->columnSpanFull()
                    ->optimize('webp'),
                CKEditor::make('message')
                    ->label(__('admin/dashboard.notice.details'))
                    ->columnSpan('full'),
                Forms\Components\Grid::make(3)->schema([
                    Select::make('status')
                        ->options(['active' => 'Active', 'inactive' => 'Inactive'])->label(trans('admin/dashboard.event.status'))
                        ->required()->columnSpan("1"),
                    DatePicker::make('start_time')
                        ->format("Y-m-d")
                        ->label(trans('admin/dashboard.event.start_time'))
                        ->reactive()
                        ->columnSpan("1")
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('end_time', null);
                        }),
                    DatePicker::make('end_time')
                        ->format("Y-m-d")
                        ->label(trans('admin/dashboard.event.end_time'))
                        ->columnSpan(1)
                        ->minDate(fn (callable $get) => $get('start_time') ?? now())
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('popup_name')->label(trans('admin/dashboard.popup_name'))->searchable(),
//                TextColumn::make('title')->label(trans('cgo.title'))->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label(trans('admin/dashboard.event.status'))
                    ->getStateUsing(fn ($record) => $record->status === 'active')
                    ->updateStateUsing(fn ($record, $state) => $record->update(['status' => $state ? 'active' : 'inactive'])),
//                ImageColumn::make('image')->label(trans('admin/dashboard.banner.image_section')),
                TextColumn::make('start_time')->label(trans('admin/dashboard.event.start_time'))->date("Y-m-d"),
                TextColumn::make('end_time')->label(trans('admin/dashboard.event.end_time'))->date("Y-m-d"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_time', 'desc');
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
            'index' => Pages\ListPopups::route('/'),
            'create' => Pages\CreatePopup::route('/create'),
            'edit' => Pages\EditPopup::route('/{record}/edit'),
        ];
    }
}
