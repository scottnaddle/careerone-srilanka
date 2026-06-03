<?php

namespace App\Filament\Widgets;

use App\Models\Institute;
use App\Models\TraineeUser;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class TraineeTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    public array $data;
    public string $type;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->traineeInstitute($this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),
                    Tables\Columns\TextColumn::make('first_name')
                    ->label(__('admin/institute_performance.institute_name'))
                    ->limit(25)
                    ->visible($this->type == 'institute')
                    ,

                Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))
                    ->alignCenter()
                    ,

                Tables\Columns\TextColumn::make('trainee_count')
                    ->label(__('admin/dashboard.member_signup.trainee'))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_portfolios')
                    ->label(__('admin/dashboard.trainee.portfolio'))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_career_test')
                    ->label(__('admin/dashboard.trainee.career_test'))
                    ->alignCenter(),

            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) str(__('admin/cgo_performance.trainee_uploading.title'))
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/cgo_performance.view_more'))
                    ->url(url('/admin/trainees'))
                    ->icon('heroicon-o-chevron-right' )
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            // ->recordUrl(
            //     fn (Model $record): string => url('admin/jobs/company?company_id=' . $record->company_id), // Open all company jobs page
            // )
            ->openRecordUrlInNewTab()
            ->emptyStateHeading(__('admin/cgo_performance.contents_uploading.no_content_found'));
    }
    public function traineeInstitute($data = [])
    {
        $query = Institute::query()
            ->leftJoin('trainee_institutes', 'institutes.id', '=', 'trainee_institutes.institute_id')
            ->join('trainee_users', 'trainee_institutes.trainee_id', '=', 'trainee_users.id')
            ->leftJoin('portfolios', 'trainee_users.id', '=', 'portfolios.trainee_id')
            ->leftJoin('career_test_trainee_results', 'trainee_users.id', '=', 'career_test_trainee_results.trainee_id')
            ->selectRaw('
        institutes.id AS id,
        COUNT(DISTINCT trainee_users.id) AS trainee_count,
        institutes.name AS first_name,
        institutes.institute_head_office,
        COUNT(DISTINCT portfolios.id) AS total_portfolios,
        COUNT(DISTINCT career_test_trainee_results.id) AS total_career_test
    ');
        if (!empty($data['head_office'])) {
            $query->where('institutes.institute_head_office', $data['head_office']);
        }
        $query->groupBy(
                'institutes.id',
                'institutes.name',
                'institutes.institute_head_office'
            )
            ->orderByRaw('(COUNT(DISTINCT portfolios.id) + COUNT(DISTINCT career_test_trainee_results.id)) DESC');
        return $query;
    }


}
