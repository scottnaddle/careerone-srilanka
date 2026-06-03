<?php

namespace App\Filament\Resources\CounselingResource\Widgets;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Services\Admin\CounselingService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Carbon\Carbon;

class CounselingOverviewTableWidget extends BaseWidget
{
    protected CounselingService $counseligService;
    protected static string $view = 'filament.widgets.custom-table-widget';

    public function __construct()
    {
        $this->counseligService = new CounselingService(new \App\Models\CgoCounseling());
    }

    // --- SỬA LẠI ĐOẠN NÀY ---
    public function rendering($view, $data)
    {
        // 1. Lấy Records (Khi phân trang, biến này trả về instance của LengthAwarePaginator)
        $records = $this->getTable()->getRecords();

        // 2. Lấy số trang hiện tại từ Paginator
        $page = $records->currentPage();

        // 3. Gửi số trang sang Chart
        $this->dispatch('update-chart-page', page: $page);
    }
    // ------------------------

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_date', 'desc')
            ->query($this->counseligService->getCounselings())
            ->queryStringIdentifier('counseling_overview_table')
            ->columns([
                TextColumn::make('No.')->label(__('admin/dashboard.counseling.no'))->rowIndex()->alignCenter(),
                TextColumn::make('created_date')->label(__('admin/dashboard.counseling.date'))->color('red')->sortable()
                    ->getStateUsing(fn ($record) => Carbon::parse($record->created_date)->format('Y-m-d')),
                TextColumn::make('title')->label(__('admin/dashboard.counseling.request'))->alignCenter()->limit(50)
                    ->getStateUsing(fn ($record) => $record->status_request),
                TextColumn::make('appliesTypeApply')->alignCenter()->label(__('admin/dashboard.counseling.confirmed'))
                    ->getStateUsing(fn ($record) => $record->status_confirm),
                TextColumn::make('appliesTypeMatch')->alignCenter()->label(__('admin/dashboard.counseling.completed'))
                    ->getStateUsing(fn ($record) => $record->status_completed),
            ])
            ->heading((string) str(__('admin/dashboard.counseling.title'))->beforeLast('Widget')->kebab()->replace('-', ' ')->title())
            ->headerActions([
                Action::make('counseling')->label(__('admin/dashboard.view_more'))->url(url('/admin/counselings'))
                    ->icon('heroicon-o-chevron-right')->iconPosition('after')->extraAttributes(['class' => 'view-more-button'])
            ])
            // Lưu ý: Đảm bảo số lượng phân trang ở đây khớp với logic cắt dữ liệu bên Chart
            // Nếu bên Chart bạn để $perPage = 5, thì ở đây nên là paginated([5])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->striped();
    }
}
