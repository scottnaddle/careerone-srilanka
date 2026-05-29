<?php

namespace App\Filament\Resources\QuestionsAndAnswersResource\Widgets;

use App\Services\Admin\QuestionsAndAnswersService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class QuestionsAndAnswersTableWidget extends BaseWidget
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
        $this->type = 'default';
    }

    // --- THÊM HÀM NÀY ---
    public function rendering($view, $data)
    {
        $records = $this->getTable()->getRecords();
        $page = $records->currentPage();
        $this->dispatch('update-qna-chart-page', page: $page);
    }
    // --------------------

    public function table(Table $table): Table
    {
        $dataQuery = $this->questionsAndAnswersService->getQNAs($this->type);

        return $table
            ->defaultSort('created_date', 'desc')
            ->heading(
                (string) str(__('admin/dashboard.qna.title_table'))
                    ->beforeLast('Widget')
            )
            ->query($dataQuery)
            // QUAN TRỌNG: Thêm identifier để URL phân trang không bị xung đột với các bảng khác
            ->queryStringIdentifier('qna_table')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_date')
                    ->label(__('admin/dashboard.qna.date'))
                    ->sortable()
                    ->getStateUsing(fn($record) => $record->created_date ?? 'N/A'),

                Tables\Columns\TextColumn::make('cgo')
                    ->label('CGO')
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->cgo ?? 0),

                Tables\Columns\TextColumn::make('company')
                    ->label('Company')
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->company ?? 0),

                Tables\Columns\TextColumn::make('trainee')
                    ->label('Trainee')
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->trainee ?? 0),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5]) // Khớp với logic cắt 5 dòng bên Chart
            ->emptyStateHeading(__('admin/dashboard.qna.no_qna'))
            ->headerActions([
                Tables\Actions\Action::make('qnas')
                    ->label(__('admin/dashboard.view_more'))
                    ->url(url('/admin/information/q-as'))
                    ->icon('heroicon-o-chevron-right' )
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ]);
    }
}
