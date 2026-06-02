<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolKidResource\Pages;
use App\Models\District;
use App\Models\SchoolKid;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class SchoolKidResource extends Resource
{
    protected static ?string $model = SchoolKid::class;

    protected static ?string $navigationLabel = 'SchoolKid (Trainee)';
    protected static ?string $navigationGroup = 'Trainee';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('nic')
                            ->label('NIC')
                            ->maxLength(12),
                        Forms\Components\Select::make('gender')
                            ->label('Gender')
                            ->options([
                                '1' => 'Male',
                                '2' => 'Female',
                                '3' => 'N/A',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('mobile')
                            ->label('Mobile')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('telephone')
                            ->label('Telephone')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('contact_address')
                            ->label('Contact Address')
                            ->maxLength(500),
                        Forms\Components\Select::make('district_id')
                            ->label('District')
                            ->options(District::orderBy('name')->pluck('name', 'id'))
                            ->searchable(),
                    ])->columns(2),

                Forms\Components\Section::make('Account Settings')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->maxLength(255),
                        Forms\Components\Toggle::make('active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->native(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Name, NIC or Email')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('fullName')
                    ->label('Name')
                    ->getStateUsing(fn($record) => $record->fullName ?? 'N/A')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('nic')
                    ->label('NIC')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->wrap(),

                Tables\Columns\TextColumn::make('mobile')
                    ->label('Mobile')
                    ->wrap(),

                Tables\Columns\TextColumn::make('district.name')
                    ->label('District')
                    ->sortable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->boolean()
                    ->getStateUsing(fn($record) => !is_null($record->email_verified_at)),

                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),

                Tables\Filters\SelectFilter::make('district_id')
                    ->label('District')
                    ->options(District::orderBy('name')->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->tooltip('View'),

                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit')
                    ->visible(fn() => auth('admin')->user()->hasRole('super_admin')),

                Action::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->iconButton()
                    ->tooltip('Deactivate')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => false]);
                    })
                    ->hidden(fn($record) => $record->active === false)
                    ->visible(fn() => auth('admin')->user()->hasRole('super_admin')),

                Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->iconButton()
                    ->tooltip('Activate')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => true]);
                    })
                    ->hidden(fn($record) => $record->active === true)
                    ->visible(fn() => auth('admin')->user()->hasRole('super_admin')),

                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete')
                    ->requiresConfirmation()
                    ->visible(fn() => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth('admin')->user()->hasRole('super_admin')),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchoolKids::route('/'),
            'create' => Pages\CreateSchoolKid::route('/create'),
            'view' => Pages\ViewSchoolKid::route('/{record}'),
            'edit' => Pages\EditSchoolKid::route('/{record}/edit'),
        ];
    }
}
