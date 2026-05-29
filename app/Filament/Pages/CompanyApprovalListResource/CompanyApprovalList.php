<?php

namespace App\Filament\Pages\CompanyApprovalListResource;

use App\Filament\Resources\CGOResource;
use App\Filament\Widgets\CompanyApprovalListtable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Actions\Action;
use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\District;
use App\Models\Company;

class CompanyApprovalList extends  Page
{
    protected static ?string $navigationLabel = 'Company Approval List';
    protected static ?string $navigationGroup = 'Company';
    protected static ?int $navigationSort = 2;
    protected ?string $heading = '';
    protected static string $view = 'filament.pages.membership.company.company-approval.list';
    public $detailid;

    protected array $data = [];
    public function mount()
    {
        $this->data = [
            'sector' => request()->query('sector', null),
            'district' => request()->query('district', null),
            'company' => request()->query('company', null),
            'search_status'=>request()->query('search-status', null),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            CompanyApprovalListtable::make([
                'data' => $this->data,
            ]),
        ];
    }
    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }
    protected function getSector()
    {
        return Sector::get();
    }
    protected function getDistrict()
    {
        return District::get();
    }
    protected function getCompany()
    {
        return Company::get();
    }
}
