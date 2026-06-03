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
use Filament\Tables\Actions\ExportAction;
use App\Exports\CgoApprovalUserExporter;

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
            ->whereNull('verify_by')
            ->whereNull('verify_at');

        $user = auth('admin')->user();

        // Filter by institute based on user role
        if (!$user->hasRole('super_admin')) {
            $userTvetType = $user->tvet_type;
            if ($userTvetType) {
                $instituteIds = Institute::where('institute_head_office', $userTvetType)
                    ->pluck('id')
                    ->toArray();
                $query->whereIn('institute_id', $instituteIds);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Handle search
        if (!empty($this->data['search'])) {
            $searchTerm = '%' . $this->data['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm);
            });
        }

        // Handle institute filter
        if (!empty($this->data['institute'])) {
            $query->where('institute_id', $this->data['institute']);
        }

        // Handle time filter
        if ($this->searchTime !== 'all') {
            $query->whereDate('created_at', '<=', now()->subDays(30));
        }

        // Handle sorting
        if (!empty($this->data['search_time'])) {
            if ($this->data['search_time'] === 'recently') {
                $query->orderBy('created_at', 'desc');
            } elseif ($this->data['search_time'] === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        self::$totalCgo = $query->count();

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
                ->action(function (EloquentCollection $records) {
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
                ->action(function (EloquentCollection $records, array $data) {
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
        return [
            Tables\Columns\TextColumn::make('index')
                ->rowIndex()
                ->alignCenter()
                ->sortable()
                ->label('No.'),
            Tables\Columns\TextColumn::make('institute.name')
                ->label(__('company.job_support.trainee_list.filter.institution'))
                ->sortable(),
            Tables\Columns\TextColumn::make('district.name')
                ->label(trans('trainee.job_support.company.table.label.district'))
                ->sortable(),
            Tables\Columns\TextColumn::make('fullName')
                ->label(trans('trainee.my_page.full_name'))
                ->searchable(['first_name', 'last_name'])
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('admin/dashboard.cgo.created_at'))
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->hasRole('super_admin');

        $filters = [];

        if ($isSuperAdmin) {
            // Filter cho super_admin: có thể chọn TVET và Institute
            $filters[] = Filter::make('tvet_type')
                ->form([
                    Select::make('tvet_type')
                        ->label(__('admin/dashboard.cgo.tvet_type'))
                        ->options(TvetType::all()->pluck('head_office_name', 'head_office_code'))
                        ->preload()
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('institute_select', null);
                        }),

                    Select::make('institute_select')
                        ->label(__('admin/dashboard.cgo.institute_name'))
                        ->options(function (callable $get) {
                            $tvetCode = $get('tvet_type');
                            if ($tvetCode) {
                                return Institute::where('institute_head_office', $tvetCode)
                                    ->orderBy('name', 'asc')
                                    ->pluck('name', 'id');
                            }
                            return [];
                        })
                        ->preload()
                        ->searchable()
                        ->visible(fn(callable $get) => !empty($get('tvet_type'))),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['tvet_type'])) {
                        $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])
                            ->pluck('id')
                            ->toArray();
                        $query->whereIn('institute_id', $instituteIds);
                    }

                    if (!empty($data['institute_select'])) {
                        $query->where('institute_id', $data['institute_select']);
                    }
                });
        } else {
            // Filter cho admin thường: chỉ hiển thị institute thuộc tvet_type của họ
            $userTvetType = $user->tvet_type;

            if ($userTvetType) {
                $instituteOptions = Institute::where('institute_head_office', $userTvetType)
                    ->orderBy('name', 'asc')
                    ->pluck('name', 'id')
                    ->toArray();

                $filters[] = Filter::make('institute_filter')
                    ->form([
                        Select::make('institute_select')
                            ->label(__('admin/dashboard.cgo.institute_name'))
                            ->options($instituteOptions)
                            ->preload()
                            ->searchable()
                            ->placeholder('All Institutes'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['institute_select'])) {
                            $query->where('institute_id', $data['institute_select']);
                        }
                    });
            }
        }

        return $filters;
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
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(CgoApprovalUserExporter::class)
                ->label('Export')
                ->color('success')
                ->modifyQueryUsing(function (Builder $query) {
                    $user = auth('admin')->user();

                    // Áp dụng filter role
                    if (!$user->hasRole('super_admin')) {
                        $userTvetType = $user->tvet_type;
                        if ($userTvetType) {
                            $instituteIds = Institute::where('institute_head_office', $userTvetType)
                                ->pluck('id')
                                ->toArray();
                            $query->whereIn('institute_id', $instituteIds);
                        } else {
                            $query->whereRaw('1 = 0');
                        }
                    }

                    // Chỉ export CGO chưa được duyệt
                    $query->whereNull('verify_by')
                        ->whereNull('verify_at');

                    // Áp dụng các filter từ widget
                    if (!empty($this->data['search'])) {
                        $searchTerm = '%' . $this->data['search'] . '%';
                        $query->where(function ($q) use ($searchTerm) {
                            $q->where('first_name', 'like', $searchTerm)
                                ->orWhere('last_name', 'like', $searchTerm);
                        });
                    }

                    if (!empty($this->data['institute'])) {
                        $query->where('institute_id', $this->data['institute']);
                    }

                    if ($this->searchTime !== 'all') {
                        $query->whereDate('created_at', '<=', now()->subDays(30));
                    }

                    // Áp dụng filter từ form filters
                    $filters = request()->query('tableFilters', []);

                    if (!empty($filters['tvet_type']['tvet_type'])) {
                        $instituteIds = Institute::where('institute_head_office', $filters['tvet_type']['tvet_type'])
                            ->pluck('id')
                            ->toArray();
                        $query->whereIn('institute_id', $instituteIds);
                    }

                    if (!empty($filters['tvet_type']['institute_select'])) {
                        $query->where('institute_id', $filters['tvet_type']['institute_select']);
                    }

                    if (!empty($filters['institute_filter']['institute_select'])) {
                        $query->where('institute_id', $filters['institute_filter']['institute_select']);
                    }
                }),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
}
