<?php

namespace App\Services\Trainee;

use App\Models\PolicyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentService
{
    public function getEmployments()
    {
        $data = [];
        $results = PolicyCategory::with(['policies' => function ($query) {
            $query->get()->each(function ($policy) {
                $policy->file = asset($policy->file);
            });
        }])->paginate(5);
        $data['total'] = $results->count();
        $data['data'] = $results;
        return $data;
    }


    public function getNewsletter(Request $request)
    {
        $groupedData = DB::table('new_letters')
            ->select(DB::raw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count'))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        $results = [];
        $counter = 0;
        foreach ($groupedData as $data) {
            $year = $data->year;
            if ($request->has('year') && $request->query('year')) {
                $year = $request->query('year');
            }
            $month = $data->month;

            $details = DB::table('new_letters')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();

            if ($details->count() > 0) {
                $counter += $data->count;
                $results[$year][$month] = [
                    'count' => $data->count,
                    'details' => $details
                ];
            }
        }

        return [$results, $counter];
    }
}
