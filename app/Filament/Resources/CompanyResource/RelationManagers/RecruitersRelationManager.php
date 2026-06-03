<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use App\Models\CompanyRecruiter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RecruitersRelationManager extends RelationManager
{
    protected static string $relationship = 'recruiters';

    protected static ?string $title = 'Recruiters';

    protected static ?string $recordTitleAttribute = 'email';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(150)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),
                Forms\Components\TextInput::make('telephone')
                    ->label('Telephone')
                    ->tel()
                    ->required()
                    ->maxLength(20),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('fullName')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => $record->fullName ?? 'N/A')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied'),

                Tables\Columns\TextColumn::make('telephone')
                    ->label('Telephone'),

                Tables\Columns\TextColumn::make('approval')
                    ->label('Approval')
                    ->getStateUsing(fn ($record) => $record->statusCompanyUser())
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'Verified' => 'Verified',
                        'Request' => 'Request',
                        default => 'Rejected',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Verified' => 'success',
                        'Request' => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Recruiter')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['company_id'] = $this->getOwnerRecord()->id;
                        if (!empty($data['password'])) {
                            $data['password'] = bcrypt($data['password']);
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->tooltip('View'),

                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
