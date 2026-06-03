<?php

namespace App\Filament\Pages\AdministratorApprovalListResource;
use App\Filament\Widgets\AdministratorApprovalListtable;
use Filament\Pages\Page;
use Illuminate\Http\Request;
use App\Models\TvetType;

class AdministratorApprovalList extends  Page
{       
    protected static ?string $navigationLabel = 'Administrator Approval List';
    protected static ?string $navigationGroup = 'Administrator';
    protected static ?int $navigationSort = 2;
    protected ?string $heading = '';
    protected static string $view = 'filament.pages.membership.admin.admin-approval.list';
    protected array $data = [];

    public function mount(Request $request)
    {
        $this->data = [
            'search' => request()->query('search', null),
            'date' => request()->query('datePicker', null),
            'tvet_type' => request()->query('tvet', null),

        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            AdministratorApprovalListtable::make([
                'data'=>$this->data
            ]),
        ];
    }
    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }
    protected function getTVET()
    {
        return TvetType::get();
    }
}
