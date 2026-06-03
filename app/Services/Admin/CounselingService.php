<?php

namespace App\Services\Admin;

use App\Models\CgoCounseling;
use App\Enums\JobStatusEnum;
use App\Models\CgoUser;
use App\Models\Institute;
use App\Models\Job;
use Carbon\Carbon;
use \App\Enums\CgoCounselingStatusEnums;
class CounselingService
{
    protected object $model;

    /**
     * CounselingService constructor.
     * @param CgoCounseling $model
     */
    public function __construct(CgoCounseling $model) {
        $this->model = $model;
    }

//    public function getCounselings($page = 'cgo', $data = [])
//{
//    $counseling=CgoCounseling::query()
//    ->selectRaw("
//        DATE(cgo_counselings.created_at) as created_date,
//        MAX(cgo_counselings.id) as id,
//        COUNT(*) as content_count,
//        SUM(CASE WHEN cgo_counselings.status = ".\App\Enums\CgoCounselingStatusEnums::REQUEST->value." THEN 1 ELSE 0 END) as status_request,
//        SUM(CASE WHEN cgo_counselings.status = ".\App\Enums\CgoCounselingStatusEnums::CONFIRM->value." THEN 1 ELSE 0 END) as status_confirm,
//        SUM(CASE WHEN cgo_counselings.status = ".\App\Enums\CgoCounselingStatusEnums::COMPLETED->value."  AND cgo_counselings.result IS NOT NULL THEN 1 ELSE 0 END) as status_completed,
//        SUM(CASE WHEN cgo_counselings.status = ".\App\Enums\CgoCounselingStatusEnums::CANCELED->value." THEN 1 ELSE 0 END) as status_canceled
//    ")
//    ->whereNotNull('result')
//    ->groupBy(\DB::raw("DATE(cgo_counselings.created_at)"));
//    return $counseling ;
//}
    public function getCounselings($page = 'cgo', $data = [])
    {
        $user = auth('admin')->user();
        $isAdmin = $user->hasRole('admin');
        $instituteIds = null;

        // Nếu là admin, lấy danh sách institute IDs dưới quyền
        if ($isAdmin) {
            $instituteIds = $user->institutes()->pluck('institutes.id')->toArray();
        }

        $counseling = CgoCounseling::query()
            ->selectRaw("
            DATE(cgo_counselings.created_at) as created_date,
            MAX(cgo_counselings.id) as id,
            COUNT(*) as content_count,
            SUM(CASE WHEN cgo_counselings.status = ? THEN 1 ELSE 0 END) as status_request,
            SUM(CASE WHEN cgo_counselings.status = ? THEN 1 ELSE 0 END) as status_confirm,
            SUM(CASE WHEN cgo_counselings.status = ? AND cgo_counselings.result IS NOT NULL THEN 1 ELSE 0 END) as status_completed,
            SUM(CASE WHEN cgo_counselings.status = ? THEN 1 ELSE 0 END) as status_canceled
        ", [
                CgoCounselingStatusEnums::REQUEST->value,
                CgoCounselingStatusEnums::CONFIRM->value,
                CgoCounselingStatusEnums::COMPLETED->value,
                CgoCounselingStatusEnums::CANCELED->value
            ])
            ->whereNotNull('result')
            ->groupBy(\DB::raw("DATE(cgo_counselings.created_at)"));
        // Nếu là admin, lọc theo institute
        if ($isAdmin && !empty($instituteIds)) {
            $counseling->whereHas('cgoUser', function ($query) use ($instituteIds) {
                $query->whereIn('institute_id', $instituteIds);
            });
        }
        return $counseling;
    }




public function getCounselingChart()
{
    $user = auth('admin')->user();
    $isAdmin = $user->hasRole('admin');
    $instituteIds = null;

    // Nếu là admin, lấy danh sách institute IDs dưới quyền
    if ($isAdmin) {
        $instituteIds = $user->institutes()->pluck('institutes.id')->toArray();
    }

    $jobQuery = CgoCounseling::query()
        ->selectRaw("
            DATE(created_at) as date,
            COUNT(CASE WHEN status = ? THEN 1 END) as request_count,
            COUNT(CASE WHEN status = ? THEN 1 END) as confirm_count,
            COUNT(CASE WHEN status = ? AND cgo_counselings.result IS NOT NULL THEN 1 END) as completed_count
        ", [
            CgoCounselingStatusEnums::REQUEST->value,
            CgoCounselingStatusEnums::CONFIRM->value,
            CgoCounselingStatusEnums::COMPLETED->value
        ])
        ->whereNotNull('result')
        ->groupBy(\DB::raw('DATE(created_at)'));

    // Nếu là admin, lọc theo institute
    if ($isAdmin && !empty($instituteIds)) {
        $jobQuery->whereHas('cgoUser', function ($query) use ($instituteIds) {
            $query->whereIn('institute_id', $instituteIds);
        });
    }

    return $jobQuery
        ->orderBy('date', 'DESC')
        // ->limit(5)
        ->get()
        ->values();
}

public function getGuidanceCGOPerformance($type, $data = [])
{
    if($type=="cgo"){
          $query = CgoUser::query()
        ->leftjoin('cgo_counseling_assign_histories', 'cgo_users.id', '=', 'cgo_counseling_assign_histories.assignee_to')
        ->leftjoin('cgo_counselings', 'cgo_counselings.id', '=', 'cgo_counseling_assign_histories.counseling_id')
        ->leftjoin('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
        ->selectRaw("
            cgo_users.id AS id,
            cgo_users.first_name AS first_name,
            cgo_users.last_name AS last_name,
            institutes.institute_head_office AS institute_head_office,
            COUNT(cgo_counselings.id) AS total_counselings,
            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::REQUEST->value . " THEN 1 ELSE 0 END) AS total_requests,
            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::CONFIRM->value . " THEN 1 ELSE 0 END) AS total_confirms,
            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::COMPLETED->value . " AND cgo_counselings.result IS NOT NULL THEN 1 ELSE 0 END) AS total_completions,
            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::CANCELED->value . " THEN 1 ELSE 0 END) AS total_cancellations
        ");
        if (!empty($data['head_office'])) {
            $query->where('institutes.institute_head_office', $data['head_office']);
        }
        $query->groupBy('cgo_users.id', 'institutes.institute_head_office', 'cgo_users.first_name', 'cgo_users.last_name')
        ->havingRaw("COUNT(cgo_counselings.id) > 0")
        ->orderByDesc('total_completions');
    }else if($type=="institute"){
//        $query = Institute::query()
//        ->join('cgo_users', 'cgo_users.institute_id', '=', 'institutes.id')
//        ->leftJoin('cgo_counseling_assign_histories', 'cgo_users.id', '=', 'cgo_counseling_assign_histories.assignee_to')
//        ->leftJoin('cgo_counselings', 'cgo_counselings.id', '=', 'cgo_counseling_assign_histories.counseling_id')
//        ->selectRaw("
//            institutes.id AS id,
//            institutes.name AS first_name,
//            institutes.institute_head_office AS institute_head_office,
//            COUNT(cgo_users.id) AS count_cgo,
//            COUNT(cgo_counselings.id) AS total_counselings,
//            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::REQUEST->value . " THEN 1 ELSE 0 END) AS total_requests,
//            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::CONFIRM->value . " THEN 1 ELSE 0 END) AS total_confirms,
//            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::COMPLETED->value . " THEN 1 ELSE 0 END) AS total_completions,
//            SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::CANCELED->value . " THEN 1 ELSE 0 END) AS total_cancellations
//        ")
//        ->groupBy('institutes.id', 'institutes.institute_head_office', 'institutes.name')
//        ->havingRaw("COUNT(cgo_counselings.id) > 0");
        $query = Institute::query()
            ->join('cgo_users', 'cgo_users.institute_id', '=', 'institutes.id')
            ->leftJoin('cgo_counseling_assign_histories', 'cgo_users.id', '=', 'cgo_counseling_assign_histories.assignee_to')
            ->leftJoin('cgo_counselings', 'cgo_counselings.id', '=', 'cgo_counseling_assign_histories.counseling_id')
            ->selectRaw("
        institutes.id AS id,
        institutes.name AS first_name,
        institutes.institute_head_office AS institute_head_office,
        COUNT(DISTINCT cgo_users.id) AS count_cgo,
        COUNT(cgo_counselings.id) AS total_counselings,
        SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::REQUEST->value . " THEN 1 ELSE 0 END) AS total_requests,
        SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::CONFIRM->value . " THEN 1 ELSE 0 END) AS total_confirms,
        SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::COMPLETED->value . " AND cgo_counselings.result IS NOT NULL THEN 1 ELSE 0 END) AS total_completions,
        SUM(CASE WHEN cgo_counselings.status = " . \App\Enums\CgoCounselingStatusEnums::CANCELED->value . " THEN 1 ELSE 0 END) AS total_cancellations
    ")
            ->where('cgo_users.active', true);
        if (!empty($data['head_office'])) {
            $query->where('institutes.institute_head_office', $data['head_office']);
        }

        $query->groupBy('institutes.id', 'institutes.institute_head_office', 'institutes.name')
            ->havingRaw("COUNT(cgo_counselings.id) > 0")
        ->orderBy('total_completions', 'desc');

    }

    return $query;
}


}
