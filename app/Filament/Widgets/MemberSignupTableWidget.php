<?php

namespace App\Filament\Widgets;

use App\Models\CgoUser;
use App\Services\Admin\MemberSignupService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class MemberSignupTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    public ?string $titleHeader = 'Member Signup';
    public ?string $namePage = 'member-signup-table';

    protected MemberSignupService $memberSignupService;

    public function __construct()
    {
        $this->memberSignupService = new MemberSignupService(
            new \App\Models\CgoUser(),
            new \App\Models\Company(),
            new \App\Models\TraineeUser()
        );
    }

    // --- THÊM ĐOẠN NÀY ---
    // Hàm này chạy mỗi khi component chuẩn bị render ra view
    public function rendering($view, $data)
    {
        // Lấy danh sách các bản ghi đang hiển thị trên trang hiện tại của bảng
        $records = $this->getTable()->getRecords();

        // Lấy ra danh sách các ngày (date)
        $dates = $records->pluck('date')->values()->toArray();

        // Bắn sự kiện sang Chart Widget kèm theo danh sách ngày
        $this->dispatch('update-chart-dates', dates: $dates);
    }
    // ---------------------

    protected function getTableQuery(): Builder|Relation|null
    {
        return $this->memberSignupService->getMemberSignupTableData(auth('admin')->user()->hasRole('admin'));
    }

    public function getTableRecordKey(\Illuminate\Database\Eloquent\Model $record): string
    {
        return $record->date ?? $record->getKey() ?? uniqid();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('No.')
                    ->label(__('admin/dashboard.member_signup.no'))
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('date')->label(__('admin/dashboard.member_signup.date'))->sortable()->alignCenter(),
                Tables\Columns\TextColumn::make('cgo_total')->label(__('admin/dashboard.member_signup.cgo'))->alignCenter(),
                Tables\Columns\TextColumn::make('trainee_total')->label(__('admin/dashboard.member_signup.trainee'))->alignCenter(),
                Tables\Columns\TextColumn::make('company_total')->label(__('admin/dashboard.member_signup.company'))->visible(auth('admin')->user()->hasRole('super_admin'))->alignCenter(),
                Tables\Columns\TextColumn::make('admin_total')->label(__('admin/dashboard.member_signup.admin'))->visible(auth('admin')->user()->hasRole('super_admin'))->alignCenter(),
                Tables\Columns\TextColumn::make('total_users')->label(__('admin/dashboard.member_signup.total'))->alignCenter(),
            ])
            ->heading(
                (string) str(__('admin/dashboard.member_signup_title'))
                    ->beforeLast('Widget')
                    ->kebab()
                    ->replace('-', ' ')
                    ->title(),
            )
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->headerActions([
                Tables\Actions\Action::make('memberSignup')
                    ->label(__('admin/dashboard.view_more'))
                    ->url(url('/admin/custom-member-signups'))
                    ->icon('heroicon-o-chevron-right' )
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            ->openRecordUrlInNewTab()
            ->queryStringIdentifier($this->namePage)
            ->defaultSort('date', 'desc')
            ->emptyStateHeading(__('admin/dashboard.member_signup.no_member_found'));
    }
}
