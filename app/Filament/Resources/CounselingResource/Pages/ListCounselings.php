<?php

namespace App\Filament\Resources\CounselingResource\Pages;

use App\Filament\Resources\CounselingResource;
use App\Models\CgoCounseling;
use App\Models\District;
use App\Models\Institute;
use App\Models\TvetType;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Http\Request;

class ListCounselings extends ListRecords
{
    protected static string $resource = CounselingResource::class;
    protected static string $view = 'filament.pages.career-guidance.counseling.counseling-list';
    protected static ?string $title = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getPeriodLabel($period): string
    {
        $labels = [
            'today' => 'Today',
            'this_week' => 'This Week',
            'this_month' =>trans('admin/performance.This Month'),
            'last_month' => trans('admin/performance.Last Month'),
            'this_quarter' => 'This Quarter',
            'this_year' => trans('admin/performance.This Year'),
            'custom' => 'Custom Range'
        ];

        return $labels[$period] ?? 'This Month';
    }

    protected function getDateRangeFromPeriod($period): array
    {
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];
            case 'this_week':
                return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];
            case 'this_month':
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                return [$lastMonth->startOfMonth(), $lastMonth->endOfMonth()];
            case 'this_quarter':
                return [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()];
            case 'this_year':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
            case 'custom':
                $startMonth = request('startMonth', $now->month);
                $startYear = request('startYear', $now->year);
                $endMonth = request('endMonth', $now->month);
                $endYear = request('endYear', $now->year);

                try {
                    $startDate = Carbon::createFromDate($startYear, $startMonth, 1)->startOfMonth();
                    $endDate = Carbon::createFromDate($endYear, $endMonth, 1)->endOfMonth();
                    return [$startDate, $endDate];
                } catch (\Exception $e) {
                    return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
                }
            default:
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        }
    }

    protected function showDistrict()
    {
        return District::all();
    }

    protected function showTvetTypes()
    {
        return TvetType::all();
    }

    protected function showInstitutes()
    {
        return Institute::orderBy('name', 'asc')->get();
    }

    protected function showCounselingType()
    {
        $language = app()->getLocale();
        return getCodeList('counselling_type', $language);
    }

    protected function showCounselingField()
    {
        $language = app()->getLocale();
        return getCodeList('counselling_field', $language);
    }
}
