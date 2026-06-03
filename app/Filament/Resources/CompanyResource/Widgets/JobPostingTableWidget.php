<?php

namespace App\Filament\Resources\CompanyResource\Widgets;

use App\Services\Admin\JobService;
use App\Services\Admin\MemberSignupService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Model;

class JobPostingTableWidget extends TableWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    protected JobService $jobService;
    public array $data;
    public ?string $titleHeader = 'Job Posting';
    public ?string $namePage = 'jobPosting';
    public string $type;

    public function __construct()
    {
        $this->jobService = new JobService(
            new \App\Models\Job()
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->jobService->getAllJobPosting($this->type, $this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('cgo_full_name')
                    ->label(__('admin/cgo_performance.cgo_name'))
                    ->getStateUsing(function ($record) {
                        return $record->cgo_first_name . ' ' . $record->cgo_last_name;
                    })
                    ->visible($this->type == 'cgo'),

                Tables\Columns\TextColumn::make('institute_name')
                    ->label(__('admin/cgo_performance.institute'))
                    ->visible($this->type == 'institute')->limit(25),
                    Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))->alignCenter()
                    ->visible($this->type == 'cgo' || $this->type == 'institute'),
                Tables\Columns\TextColumn::make('company_name')
                    ->label(__('admin/cgo_performance.company'))
                    ->limit(30)
                    ->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('district_name')->label(__('admin/cgo_performance.district'))
                    ->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('job_posting_count')
                    ->label(__('admin/cgo_performance.job_posting'))
                    ->alignCenter()
                    ->visible($this->type == 'company' && $this->namePage =='jobposting'),
                    Tables\Columns\TextColumn::make('apply_count')
                    ->label(__('admin/cgo_performance.job_apply'))
                    ->alignCenter()
                    ->visible($this->type == 'company' && $this->namePage =='jobApply'),
                    Tables\Columns\TextColumn::make('job_match_count')
                    ->label(__('admin/cgo_performance.job_matched'))
                    ->alignCenter()
                    ->visible($this->type == 'company' && $this->namePage =='jobMatch'),
                Tables\Columns\TextColumn::make('job_match_count')->label(__('admin/cgo_performance.matched_job_titlle'))->alignCenter()->visible($this->type !== 'company'),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) $this->titleHeader,
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/cgo_performance.view_more'))
                    ->url(url('admin/jobs'))
                    ->icon('heroicon-o-chevron-right')
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            ->openRecordUrlInNewTab()
            ->emptyStateHeading(__('admin/cgo_performance.matched_job.no_job'))
            ->queryStringIdentifier($this->namePage);
    }
}
