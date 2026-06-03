<?php

namespace App\Filament\Pages\CgoApprovalListResource;

use App\Filament\Resources\CGOResource;
use App\Filament\Widgets\CGOApprovalListtable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Actions\Action;
use Illuminate\Http\Request;
use App\Models\TvetType;
use App\Models\Institute;
use App\Services\CGOApprovalService;
class CgoApprovalList extends  Page
{
    protected static ?string $navigationLabel = 'CGO Approval List';
    protected static ?string $navigationGroup = 'CGO';
    protected static ?int $navigationSort = 2;
    protected ?string $heading = '';
    protected static string $view = 'filament.pages.membership.cgo.cgo-approval.list';
    public $data;
    public $totalCgo;
    public function mount(Request $request)
    {
        $this->data = [
            'search' => request()->query('search', null),
            'TVET_type' => request()->query('TVET_type', null),
            'institute' => request()->query('institute', null),
            'search_time' => request()->query('search-time', null),

        ];
        // $this->totalCgo=CGOApprovalListtable::$totalCgo;
        // dd($this->totalCgo);

    }
    protected function getFooterWidgets(): array
    {
        return [
            CGOApprovalListtable::make([
                'data' => $this->data,
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
    protected function getInstitute()
    {
        return Institute::where('active_status', 'LIKE', 'Active')->orderBy('name', 'asc')->get();
    }
}
