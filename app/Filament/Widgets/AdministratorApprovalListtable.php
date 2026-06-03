<?php

namespace App\Filament\Widgets;

use App\Models\AdminUser;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Services\Admin\SearchComponentAdminService;
use Illuminate\Database\Eloquent\Builder;



class AdministratorApprovalListtable extends BaseWidget
{
    public $search = '';
    public $option1 = '';
    public $option2 = '';
    public $searchTime = 'all';
    public $query;
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected SearchComponentAdminService $searchService;
    public array $data;
    public function __construct()
    {
        $this->searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
    }
    protected function getTableHeading(): ?string
    {
        return ''; // Ẩn tiêu đề của bảng
    }
    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.pages.administrator-approval-list');
    }
    protected function getTableQuery(): Builder
    {
         $admin = AdminUser::selectRaw("*");
        if (!isset($this->data['no_check_verify'])) {
            $admin
            // ->whereNotNull('email_verified_at')
                    ->whereNull('verify_by')
                    ->whereNull('verify_at');
        }

        if (!empty($this->data['search'])) {
                $admin->where('first_name', 'ilike', '%' . $this->data['search'] . '%')
                    ->orWhere('last_name', 'ilike', '%' . $this->data['search'] . '%');
        }
        if (isset($this->data['date'])) {
            $admin->whereDate('updated_at', $this->data['date']);
        }
        if (isset($this->data['tvet_type'])) {
            $admin->where('tvet_type', $this->data['tvet_type']);
        }
        if (!empty($this->data['search_time'])) {
            if ($this->data['search_time'] === 'recently') {
                $admin->orderBy('updated_at', 'desc');
            } elseif ($this->data['search_time'] === 'oldest') {
                $admin->orderBy('updated_at', 'asc');
            }
        } else {
            $admin->orderBy('updated_at', 'desc');
        }
        if (!empty($this->data['search_status']) && $this->data['search_status'] != 'all') {
            if ($this->data['search_status'] === 'approved') {
                $admin->whereNotNull('verify_by')
                    ->whereNotNull('verify_at');
            } elseif ($this->data['search_status'] === 'non_approved') {
                $admin->whereNull('verify_by')
                    ->whereNull('verify_at');
            }
        }
        return $admin;
    }

    protected function getTableColumns(): array
    {
        return[
            Tables\Columns\TextColumn::make('index')
            ->rowIndex()
            ->alignCenter()
            ->sortable()
            ->label('No.'),
                Tables\Columns\TextColumn::make('tvet_type')->label(__('admin/dashboard.cgo.tvet_type')) ->sortable(),
                Tables\Columns\TextColumn::make('fullName')->label('Name')->searchable(query: function ($query, $search) {
                    $query->where('first_name', 'ilike', "%{$search}%")
                        ->orWhere('last_name', 'ilike', "%{$search}%");
                }),
                Tables\Columns\TextColumn::make('nic')->label('NIC') ->sortable(),
                Tables\Columns\TextColumn::make('contact')->label('Contact')
                ->getStateUsing(function ($record) {
                    return $record->phone .'</br>'.$record->email;
                }) ->html(),
                Tables\Columns\TextColumn::make('created_at')->label('Sign-up Date')->sortable(),
            ];
    }
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('viewMore')
                ->label('View More')
                ->icon('heroicon-o-eye')
                ->action(function ($record) {
                    return redirect()->route('filament.admin.pages.administrator-approval-detail', ['id' => $record->id]);
                }),
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
}
