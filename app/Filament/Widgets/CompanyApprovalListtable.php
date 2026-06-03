<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\Sector;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Services\Admin\SearchComponentAdminService;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use App\Models\District;


class CompanyApprovalListtable extends BaseWidget
{
    protected SearchComponentAdminService $searchService;
    public array $data;
    public $query;
    public function __construct()
    {
        $this->searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
    }
    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.pages.company-approval-list');
    }
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected function getTableHeading(): ?string
    {
        return '';
    }
    protected function getTableQuery(): Builder
    {
        $query = Company::query()
            ->select([
                'companies.id',
                'companies.name as name',
                'districts.name as district_name',
                'companies.created_at',
            ])
            ->join('districts', 'districts.id', '=', 'companies.district_id')
            ->whereNull('companies.verified_by')
            ->whereNull('companies.verified_at');
        if (!empty($this->data['company'])) {
            $query->where('companies.id', $this->data['company']);
        }
        if (!empty($this->data['sector'])) {
            $query->join('jobs', 'jobs.company_id', '=', 'companies.id')
                ->where('jobs.sector_id', $this->data['sector']);
        }
        if (!empty($this->data['district'])) {
            $query->where('companies.district_id', $this->data['district']);
        }
        if (!empty($this->data['search_status']) && $this->data['search_status'] != 'all') {
            if ($this->data['search_status'] === 'approved') {
                $query->whereNotNull('companies.verified_by')
                    ->whereNotNull('companies.verified_at');
            } elseif ($this->data['search_status'] === 'non_approved') {
                $query->whereNull('companies.verified_by')
                    ->whereNull('companies.verified_at');
            }
        }
        $query->orderBy('companies.created_at', 'desc');
        $query->distinct();

        return $query;
    }




    protected function getTableColumns(): array
    {
        return[
            Tables\Columns\TextColumn::make('index')
            ->rowIndex()
            ->alignCenter()
            ->sortable()
            ->label('No.'),
            Tables\Columns\TextColumn::make('name')
            ->label('Name')
            ->limit(50)
            ->sortable()
            ->searchable('companies.name'),
//        Tables\Columns\TextColumn::make('sector')->label('Sector'),
        Tables\Columns\TextColumn::make('district_name')->label('District') ->sortable(),

    ];

    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('district_id')
                ->label('District')
                ->options(District::pluck('name', 'id')->toArray())
                ->searchable(),

//            Tables\Filters\SelectFilter::make('sector')
//                ->label('Sector')
//                ->options(Sector::pluck('name', 'id')->toArray())
//                ->searchable(),
        ];
    }
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('viewMore')
                ->icon('heroicon-o-eye')
                ->label('View More')
                ->action(function ($record) {
                    return redirect()->route('filament.admin.pages.company-approval-detail', ['id' => $record->id]);
                }),
        ];
    }



protected function getTableRecordsPerPageSelectOptions(): array
{
    return [10, 25, 50, 100];
}


}
