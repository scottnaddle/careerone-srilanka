<?php

namespace App\Filament\Widgets;

use App\Models\CgoUser;
use App\Services\Admin\HandelAdminService;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use App\Services\Admin\SearchComponentAdminService;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use App\Models\TvetType;
use App\Models\Institute;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use App\Services\CGOApprovalService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class CGOApprovalListtable extends BaseWidget
{
    protected static string $view = 'filament-widgets::table-widget';
    protected SearchComponentAdminService $searchService;
    public array $data;
    public $searchTime = 'all';
    public $query;
    public static $totalCgo; // Declare a public property
    protected HandelAdminService $approvalService;
    public function __construct()
    {
        $this->searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );

        $this->approvalService = new HandelAdminService();
    }

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getTableHeading(): ?string
    {
        return ''; // Ẩn tiêu đề của bảng
    }

    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.pages.cgo-approval-list');
    }
    protected function getTableQuery(): Builder
    {
        $query = CgoUser::query()
            // ->whereNotNull('email_verified_at')
            ->whereNull('verify_by')
            ->whereNull('verify_at');

        if ($this->data['search']) {
            $query->where('first_name', 'like', '%' . $this->data['search'] . '%')
                  ->orWhere('last_name', 'like', '%' . $this->data['search'] . '%');
        }
        if ($this->data['institute']) {
            $query->where('institute_id', $this->data['institute']);
        }

        if ($this->searchTime !== 'all') {
            $query->whereDate('created_at', '<=', now()->subDays(30));
        }
        if (!empty($this->data['search_time'])) {
            if ($this->data['search_time'] === 'recently') {
                $query->orderBy('created_at', 'desc');
            } elseif ($this->data['search_time'] === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        }else{
            $query->orderBy('created_at', 'desc');
        }
        self::$totalCgo=$query->count();
          return $query;
    }


    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('approve')
                ->label(__('system.form.button.approve'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (EloquentCollection  $records) {
                    foreach ($records as $record) {
                        $success = $this->approvalService->approve(CgoUser::class, $record->id);

                        if ($success) {
                            Notification::make()
                                ->title('Action Success!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Something wrong !')
                                ->danger()
                                ->send();
                        }
                    }
                }),

            Tables\Actions\BulkAction::make('reject')
                ->label(__('system.filter.status.reject'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label(__('Reason'))
                        ->required()->rows(5)
                        ->maxLength(250),
                ])
                ->action(function (EloquentCollection  $records, array $data) {
                    foreach ($records as $record) {
                        $success = $this->approvalService->rejectCgo(CgoUser::class, $record->id, $data['reason']);
                    }

                    if ($success) {
                        Notification::make()
                            ->title('Action Success!')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Something wrong !')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }


    protected function getTableColumns(): array
    {
        return[
        Tables\Columns\TextColumn::make('index')
        ->rowIndex()
        ->alignCenter()
        ->sortable()
        ->label('No.'),
        Tables\Columns\TextColumn::make('institute.name')->label(__('company.job_support.trainee_list.filter.institution')) ->sortable(),
        Tables\Columns\TextColumn::make('district.name')->label(trans('trainee.job_support.company.table.label.district')) ->sortable(),
        Tables\Columns\TextColumn::make('fullName')->label(trans('trainee.my_page.full_name'))->searchable()->sortable(),
        Tables\Columns\TextColumn::make('created_at')->label(__('admin/dashboard.cgo.created_at')) ->sortable(),

    ];

    }
    protected function getTableFilters(): array
    {
        return [
            Filter::make('tvet_type')
                ->form([
                    Select::make('tvet_type')
                        ->label(__('admin/dashboard.cgo.tvet_type'))
                        ->options(TvetType::all()->pluck('head_office_name', 'head_office_code'))
                        ->preload()
                        ->searchable(),

                    Select::make('institute_select')
                        ->label(__('admin/dashboard.cgo.institute_name'))
                        ->options(function (callable $get) {
                            $tvetCode = $get('tvet_type');
                            if ($tvetCode) {
                                return Institute::where('institute_head_office', $tvetCode)->orb
                                    ->pluck('name', 'id');
                            }
                            return [];
                        })
                        ->preload()
                        ->searchable()
                        ->visible(fn(callable $get) => !empty($get('tvet_type'))), // Only visible if TVET is selected
                ])
                ->query(function (Builder $query, array $data) {
                    // Filter by TVET type
                    if (!empty($data['tvet_type'])) {
                        $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])
                            ->pluck('id')
                            ->toArray();
                        $query->whereIn('institute_id', $instituteIds);
                    }

                    // Filter by Institute
                    if (!empty($data['institute_select'])) {
                        $query->where('institute_id', $data['institute_select']);
                    }
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('viewMore')
                ->label(__('system.action.view_more'))
                ->icon('heroicon-o-eye')
                ->action(function ($record) {
                    return redirect()->route('filament.admin.pages.cgo-approval-detail', ['id' => $record->id]);
                }),
                // Tables\Actions\Action::make('delete')
                // ->label('Delete')
                // ->icon('heroicon-o-trash')
                // ->color('danger')
                // ->requiresConfirmation()
                // ->action(function ($record) {
                //     $record->delete();
                //     Notification::make()
                //         ->success()
                //         ->title('Record deleted successfully')
                //         ->send();
                // }),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

}
