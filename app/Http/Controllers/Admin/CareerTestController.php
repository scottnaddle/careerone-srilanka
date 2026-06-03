<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\CareerTestTraineeResult;
use App\Models\District;
use App\Models\Institute;
use App\Models\TvetHeadquater;
use App\Models\TvetType;
use Filament\Facades\Filament;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\CareerTestExport;
use Maatwebsite\Excel\Facades\Excel;
class CareerTestController extends Controller
{
    public function viewResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            switch ($result->test_type) {
                case 1:
                    return view('homepage.career-test.results.career-interest-test-result', compact('result'));
                case 2:
                    return view('homepage.career-test.results.career-key-test-result', compact('result'));
                case 3:
                case 4:
                    return \Redirect::back()->withErrors(['msg' => 'This test type result view is not yet available.']);
                default:
                    return \Redirect::back()->withErrors(['msg' => 'Unknown test type.']);
            }

        }
        return \Redirect::back()->withErrors(['msg' => 'Sorry, We can not find this result in system!']);
    }

    public function downloadResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            return response()->download($result->attachment);
        }
        return redirect()->route('trainee.career-guidance.career-test.list')->withErrors(trans('system.information.content_management.not_found'));
    }

    public function export(Request $request)
    {
        // Lấy tham số từ request
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $period = $request->query('period', 'this_month');

        // Lấy danh sách career test types
        $language = app()->getLocale();
        $carrerTestType = getCodeList('career_test_type', $language);

        // Lấy institutes có dữ liệu trong khoảng thời gian
        $institutes = Institute::where('active_status', 'Active')
            ->whereHas('carrerTestsTraineeResult', function($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate);
                }
            })
            ->orderBy('name', 'asc')
            ->get();

        // Tạo tên file
        $fileName = 'career_test_export_' . Carbon::now()->format('Ymd_His') . '.csv';

        // Tạo headers cho CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // Tạo callback để ghi CSV
        $callback = function() use ($institutes, $carrerTestType, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Thêm BOM cho UTF-8 để hỗ trợ tiếng Việt trong Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header thông tin thời gian export
            fputcsv($file, ['Export Date:', Carbon::now()->format('d/m/Y H:i:s')]);
            fputcsv($file, ['Period:', $this->getPeriodLabel($startDate, $endDate)]);
            fputcsv($file, ['Date Range:', ($startDate ? Carbon::parse($startDate)->format('d/m/Y') : 'N/A') . ' - ' . ($endDate ? Carbon::parse($endDate)->format('d/m/Y') : 'N/A')]);
            fputcsv($file, []); // Dòng trống

            // Tạo header cho bảng
            $headers = ['No.', 'Institute'];

            // Thêm các cột cho từng loại career test
            foreach ($carrerTestType as $type) {
                $headers[] = $type->code_name;
            }

            // Thêm cột Member và Non-member
            $headers[] = 'Member';
            $headers[] = 'Non-member';
            $headers[] = 'Total';

            fputcsv($file, $headers);

            // Ghi dữ liệu
            $index = 1;
            foreach ($institutes as $institute) {
                $memberStats = $institute->countCareerTestByInstituteMember($startDate, $endDate);

                // Chỉ export institutes có dữ liệu
                if ($memberStats['member'] > 0 || $memberStats['non_member'] > 0) {
                    $row = [
                        $index++,
                        $institute->name,
                    ];

                    // Thêm dữ liệu cho từng loại career test
                    $totalByType = 0;
                    foreach ($carrerTestType as $type) {
                        $testStats = $institute->countCareerTestByInstitute($startDate, $endDate, $type->code_id);
                        $typeTotal = $testStats['member'] + $testStats['non_member'];
                        $row[] = $typeTotal;
                        $totalByType += $typeTotal;
                    }

                    // Thêm member, non-member và total
                    $row[] = $memberStats['member'];
                    $row[] = $memberStats['non_member'];
                    $row[] = $memberStats['member'] + $memberStats['non_member'];

                    fputcsv($file, $row);
                }
            }

            // Thêm dòng tổng kết
            fputcsv($file, []); // Dòng trống
            fputcsv($file, ['Summary']);
            fputcsv($file, ['Total Institutes with data:', $index - 1]);

            fclose($file);
        };

        $fileName = 'career_test_export_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new CareerTestExport($startDate, $endDate, $carrerTestType), $fileName);
    }

    private function getPeriodLabel($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return 'All Time';
        }

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Kiểm tra các period đặc biệt
        $now = Carbon::now();

        // Today
        if ($start->isToday() && $end->isToday()) {
            return 'Today';
        }

        // This Week
        if ($start->isSameDay($now->copy()->startOfWeek()) && $end->isSameDay($now->copy()->endOfWeek())) {
            return 'This Week';
        }

        // This Month
        if ($start->isSameDay($now->copy()->startOfMonth()) && $end->isSameDay($now->copy()->endOfMonth())) {
            return 'This Month';
        }

        // Last Month
        $lastMonth = $now->copy()->subMonth();
        if ($start->isSameDay($lastMonth->copy()->startOfMonth()) && $end->isSameDay($lastMonth->copy()->endOfMonth())) {
            return 'Last Month';
        }

        // This Quarter
        if ($start->isSameDay($now->copy()->startOfQuarter()) && $end->isSameDay($now->copy()->endOfQuarter())) {
            return 'This Quarter';
        }

        // This Year
        if ($start->isSameDay($now->copy()->startOfYear()) && $end->isSameDay($now->copy()->endOfYear())) {
            return 'This Year';
        }

        return 'Custom Range';
    }
}
