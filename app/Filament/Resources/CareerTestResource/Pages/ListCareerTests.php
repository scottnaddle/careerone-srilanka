<?php

namespace App\Filament\Resources\CareerTestResource\Pages;

use App\Filament\Resources\CareerTestResource;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListCareerTests extends ListRecords
{
    protected static string $resource = CareerTestResource::class;
    protected static string $view = 'filament.pages.career-guidance.carrer-test.career-test-list';
    protected static ?string $title = '';

    public function getCareerTestTraineeResult() {
        $careerTestType = CareerTest::all();

        // Get query parameters from the current URL
        $period = request()->query('period', 'this_month');

        $query = CareerTestTraineeResult::query();
        $query->whereNotNull('institute_id');
        if (auth('admin')->check() && !auth('admin')->user()->hasRole('super_admin')) {
            $institutes = auth('admin')->user()->institutes;
            $instituteIds = $institutes->pluck('id')->toArray();
            $query->whereIn('institute_id', $instituteIds);
        }

        [$startDate, $endDate] = $this->getDateRangeFromPeriod($period);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $count = $query->count();
        $paginatedResults = $query->orderBy('created_at', 'desc')->paginate(10);

        return [
            'results' => $paginatedResults,
            'count' => $count,
            'career_test_types' => $careerTestType,
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

    private function getDateRangeFromPeriod($period): array
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
}
