<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerExpertInterviewResource\Pages;
use App\Filament\Resources\CareerExpertInterviewResource\RelationManagers;
use App\Models\CareerExpertInterview;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CareerExpertInterviewResource extends Resource
{
    protected static ?string $model = CareerExpertInterview::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Expert Interviews';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->columnSpanFull()
                ->label(__('admin/dashboard.career_expert_interview.title')),

            Forms\Components\Textarea::make('intro')
                ->columnSpanFull()
                ->label(__('admin/dashboard.career_expert_interview.intro')),

            Forms\Components\TextInput::make('video_url')
                ->url()
                ->label(__('admin/dashboard.career_expert_interview.video_url'))
                ->placeholder(__('admin/dashboard.career_expert_interview.placeholder_video_url'))
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.career_expert_interview.index'))
                ->rowIndex()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->limit(50)
                ->searchable()
                ->label(__('admin/dashboard.career_expert_interview.title_table'))->wrap(),

            Tables\Columns\TextColumn::make('video_url')
                ->sortable()
                ->label(__('admin/dashboard.career_expert_interview.video_url'))->wrap(),

            TextColumn::make('created_at')
                ->date('Y-m-d')
                ->sortable()
                ->label(__('admin/dashboard.career_expert_interview.created_at'))->wrap(),
        ])->searchPlaceholder('Title')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relationships if needed, such as comments or related models
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareerExpertInterviews::route('/'),
            'create' => Pages\CreateCareerExpertInterview::route('/create'),
            'edit' => Pages\EditCareerExpertInterview::route('/{record}/edit'),
        ];
    }
}
