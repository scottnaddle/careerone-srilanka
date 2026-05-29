<?php

namespace App\Filament\Resources\JobResource\Widgets;

use App\Models\Job;
use App\Services\Admin\JobService;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class JobVacancyTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    protected JobService $jobService;

    public function __construct()
    {
        $this->jobService = new JobService(
            new \App\Models\Job()
        );
    }

    // --- THÊM ĐOẠN NÀY ---
    public function rendering($view, $data)
    {
        // 1. Lấy danh sách các bản ghi (records) đang hiển thị ở trang hiện tại
        $records = $this->getTable()->getRecords();

        // 2. Lấy danh sách ID (Primary Key) của các bản ghi này
        $ids = $records->pluck('id')->toArray();

        // 3. Bắn sự kiện sang Chart Widget kèm theo danh sách ID
        $this->dispatch('update-job-chart', ids: $ids);
    }
    // ---------------------

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('jobs.created_at', 'desc')
            ->query(
                $this->jobService->getAllJobPosting()
            )
            ->queryStringIdentifier('jobs')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('date')->label(__('admin/dashboard.job_vacancy.date'))->sortable()->alignCenter()
                    ->getStateUsing(function ($record) {
                        return Carbon::parse($record->date)->format('Y-m-d');
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->limit(25)
                    ->label(__('admin/dashboard.job_vacancy.job_posting')),
                Tables\Columns\TextColumn::make('appliesTypeApply')
                    ->alignCenter()
                    ->label(__('admin/dashboard.job_vacancy.applied'))
                    ->getStateUsing(function ($record) {
                        return $record->appliesTypeApply()->count();
                    }),

                Tables\Columns\TextColumn::make('appliesTypeMatch')
                    ->alignCenter()
                    ->label(__('admin/dashboard.job_vacancy.matched'))
                    ->getStateUsing(function ($record) {
                        return $record->appliesTypeMatch()->count();
                    }),
            ])
            ->heading(
                (string) str(__('admin/dashboard.job_vacancy_title'))
                    ->beforeLast('Widget')
                    ->kebab()
                    ->replace('-', ' ')
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/dashboard.view_more'))
                    ->url(url('/admin/jobs'))
                    ->icon('heroicon-o-chevron-right' )
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->striped();
    }
}
