<?php

namespace App\Filament\Widgets\CountCounselingByRole;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Services\Admin\QuestionsAndAnswersService;

class CounselingTableWidget extends BaseWidget
{   
     protected static string $view = 'filament.widgets.custom-table-widget';
    protected QuestionsAndAnswersService $questionsAndAnswersService;
    public array $data;
    public ?string $titleHeader = 'Q&A Reply';
    public ?string $namePage = 'qna';
    public string $type;

    public function __construct()
    {
        $this->questionsAndAnswersService = new QuestionsAndAnswersService(
            new \App\Models\QNA()
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->questionsAndAnswersService->getQNAs($this->type, $this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('No.')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('cgo_full_name')
                    ->label('CGO Name')
                    ->getStateUsing(function ($record) {
                        return $record->cgo_first_name . ' ' . $record->cgo_last_name;
                    })
                    ->visible($this->type == 'cgo'),
                Tables\Columns\TextColumn::make('institute_name')
                    ->label('Institute')
                    ->visible($this->type == 'institute' || $this->type == 'cgo'),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Company')
                    ->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('district_name')->label('District'),
                Tables\Columns\TextColumn::make('sector_name')
                    ->label('Job catagory')
                    ->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('qna_count')->label('Sum'),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) str($this->titleHeader)
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label('View more')
                    ->url(url('/admin/information/q-as'))
                    ->icon('heroicon-o-chevron-right' )
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            // ->recordUrl(
            //     fn (Model $record): string => url(''),
            // )
            ->openRecordUrlInNewTab()
            ->queryStringIdentifier($this->namePage)
            ->emptyStateHeading('No Q&A found');
    }
}
