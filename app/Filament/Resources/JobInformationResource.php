<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobInformationResource\Pages;
use App\Models\JobInformation;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
class JobInformationResource extends Resource
{
    protected static ?string $model = JobInformation::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Job Management';
    protected static ?string $modelLabel = 'Job Outlook';



    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label(__('admin/dashboard.job_information.title')),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->disabled()
                ->hidden()
                ->label(__('admin/dashboard.job_information.slug')),
            Forms\Components\Select::make('sector_id')
                ->label(__('admin/dashboard.job_information.sector_id'))
                ->relationship('sectors', 'name')
                ->required(),
            Forms\Components\TextInput::make('expected_income_per_month')
                ->columnSpanFull()
                ->label(__('admin/dashboard.job_information.expected_income_per_month')),
            Forms\Components\Textarea::make('description')
                ->label(__('admin/dashboard.job_information.description')),
            Forms\Components\Textarea::make('duties_of_the_job')
                ->label(__('admin/dashboard.job_information.duties_of_the_job')),

            // Skills with range input for value and text input for label
            Forms\Components\Repeater::make('skills')
                ->label(__('admin/dashboard.job_information.skills'))
                ->schema([
                    Forms\Components\TextInput::make('value')
                        ->label(__('admin/dashboard.job_information.skill_value'))
                        ->type('range')
                        ->extraAttributes([
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ])
                        ->default(50),
                    Forms\Components\TextInput::make('text')
                        ->label(__('admin/dashboard.job_information.skill_label')),
                ])
                ->columns(2)
                ->minItems(1)
                ->required(),

            Forms\Components\Repeater::make('knowledge')
                ->label(__('admin/dashboard.job_information.knowledges'))
                ->schema([
                    Forms\Components\TextInput::make('value')
                        ->label(__('admin/dashboard.job_information.knowledge_value'))
                        ->type('range')
                        ->extraAttributes([
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ])
                        ->default(50),
                    Forms\Components\TextInput::make('text')
                        ->label(__('admin/dashboard.job_information.knowledge_label')),
                ])
                ->columns(2)
                ->minItems(1)
                ->required(),

            Forms\Components\Repeater::make('related_occupations')
                ->label(__('admin/dashboard.job_information.related_occupations'))
                ->schema([
                    Forms\Components\TextInput::make('occupation')
                        ->label(__('admin/dashboard.job_information.occupation')),
                ]),

            Forms\Components\Repeater::make('benefits')
                ->label(__('admin/dashboard.job_information.benefits'))
                ->schema([
                    Forms\Components\TextInput::make('benefits')
                        ->label(__('admin/dashboard.job_information.benefit_label')),
                ]),

            Forms\Components\TextInput::make('created_by')
                ->numeric()
                ->required()
                ->hidden()
                ->label(__('admin/dashboard.job_information.created_by')),

            FileUpload::make('attachment_details')
                ->multiple()
                ->directory('job-information-attachments')
                ->preserveFilenames()
                ->columnSpan('full')
                ->required()
                ->openable()
                ->downloadable()
                ->reactive()
                ->optimize('webp')
                ->label(__('admin/dashboard.job_information.attachment_details')),
        ]);

    }
    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.job_information.index'))
                ->rowIndex()
                ->alignCenter(),

            TextColumn::make('title')
                ->label(__('admin/dashboard.job_information.title'))
                ->sortable()
                ->limit(50)
                ->searchable(),

            TextColumn::make('sectors.name')
                ->label(__('admin/dashboard.job_information.sector'))
                ->sortable(),

            TextColumn::make('skills')
                ->label(__('admin/dashboard.job_information.skills_value'))
                ->formatStateUsing(function ($state) {
                    $skills = json_decode($state, true);
                    return collect($skills)->map(function ($skill) {
                        return "{$skill['text']} (Value: {$skill['value']})";
                    })->implode(', ');
                }),

            TextColumn::make('knowledge')
                ->label(__('admin/dashboard.job_information.knowledges_value'))
                ->formatStateUsing(function ($state) {
                    $knowledges = json_decode($state, true);
                    return collect($knowledges)->map(function ($knowledge) {
                        return "{$knowledge['text']} (Value: {$knowledge['value']})";
                    })->implode(', ');
                }),

            TextColumn::make('expected_income_per_month')
                ->label(__('admin/dashboard.job_information.expected_income_per_month'))
                ->sortable(),
        ])
            ->searchPlaceholder('Title')
            ->filters([
                SelectFilter::make('sector')
                    ->relationship('sectors', 'name')
                    ->label('Job catagory'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobInformation::route('/'),
            'create' => Pages\CreateJobInformation::route('/create'),
            'edit' => Pages\EditJobInformation::route('/{record}/edit'),
            'view' => Pages\ViewJobInformation::route('/{record}'),
        ];
    }
}
