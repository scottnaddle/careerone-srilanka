<?php

namespace App\Services\Admin;

use App\Enums\JobStatusEnum;
use App\Models\Job;
use App\Models\TraineeApply;
use Filament\Forms\Components\Builder;

class JobService
{
    protected object $model;

    /**
     * JobService constructor.
     * @param Job $model
     */
    public function __construct(Job $model)
    {
        $this->model = $model;
    }

    public function getAllJob(array $data = [])
    {
        $jobQuery = $this->model->query();
        if (isset($data['sector'])) {
            $jobQuery->where('sector_id', $data['sector']);
        }

        if (isset($data['district'])) {
            $district = $data['district'];
            $jobQuery->whereHas('company', function ($query) use ($district) {
                $query->where('district', $district);
            })->get();
        }

        if (isset($data['start']) && isset($data['end'])) {
            $datefrom = $data['start'];
            $dateto = $data['end'];
            $jobQuery->where(function ($query) use ($datefrom, $dateto) {
                $query->whereBetween('application_starttime', array($datefrom, $dateto));
            });
        }

        if (isset($data['status']) && $data['status']!= 'all') {
            $status= $data['status']=='in_progress' ? '1':'0';
            $jobQuery->where('status', $status);
        }

        return $jobQuery;
    }
    /**
     * @param $type string cgo, institute, company or empty
     * @param $data array data for where clause
     * @return mixed
     */
    public function getAllJobPosting(string $type = '', array $data = []): mixed
    {
//        $jobQuery = $this->model->query()->selectRaw("
//            MAX(districts.name) as district_name,
//            COUNT(*) as job_count
//        ");
        $jobQuery = $this->model->query();

        switch ($type) {
            case 'cgo':
                $jobQuery = $this->applyCgoQuery($jobQuery, $data);
                break;

            case 'institute':
                $jobQuery = $this->applyInstituteQuery($jobQuery, $data);
                break;

            case 'company':
                $jobQuery = $this->applyCompanyQuery($jobQuery, $data);
                break;

            default:
                $jobQuery = $this->applyQuery($jobQuery, $data);
                break;
        }

        // Apply common filters
        if (isset($data['keywords_search'])) {
            $this->applyKeywordSearch($jobQuery, $type, $data['keywords_search']);
        }

        return $jobQuery;
    }

    public function getJobChart()
{
            $jobQuery = Job::query()->selectRaw("
            jobs.id,
            jobs.title,
            jobs.created_at as date,
            COUNT(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE NULL END) as appliesTypeApply,
            COUNT(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE NULL END) as appliesTypeMatch
        ")
        ->leftJoin('trainee_applies', 'jobs.id', '=', 'trainee_applies.job_id')
        ->havingRaw("
        COUNT(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE NULL END) > 0
        OR
        COUNT(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE NULL END) > 0
        ")
        ->groupBy('jobs.id', 'jobs.title', 'jobs.created_at')
        ->orderBy('date', 'DESC')
        ->limit(5)
        ->get();

        return $jobQuery;
    }

    private function applyCgoQuery($jobQuery, $data= [])
    {
        return $jobQuery->selectRaw('
            MAX(cgo_users.id) as id,
            MAX(cgo_users.first_name) as cgo_first_name,
            MAX(cgo_users.last_name) as cgo_last_name,
            MAX(institutes.name) as institute_name,
            institutes.institute_head_office AS institute_head_office
        ')
            ->selectRaw('COUNT(trainee_matches.id) as job_match_count')
            ->join('trainee_matches', 'jobs.id', '=', 'trainee_matches.job_id')
            ->join('cgo_users', 'trainee_matches.created_by', '=', 'cgo_users.id')
            ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
            ->join('districts', 'cgo_users.district_id', '=', 'districts.id')
            ->when(!empty($data['head_office']), function ($query) use ($data) {
                $query->where('institutes.institute_head_office', $data['head_office']);
            })
            ->groupBy('cgo_users.id', 'institutes.id')
            ->orderBy('job_match_count', 'DESC');
    }


//    private function applyInstituteQuery($jobQuery, $data)
//    {
////        $jobQuery->selectRaw("
////            MAX(institutes.id) as id,
////            MAX(institutes.name) as institute_name,
////            SUM(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE 0 END) as apply_count,
////            SUM(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE 0 END) as job_match_count,
////            institutes.institute_head_office AS institute_head_office
////        ")
////            ->join('trainee_applies', 'jobs.id', '=', 'trainee_applies.job_id')
////            ->join('companies', 'jobs.company_id', '=', 'companies.id')
////            ->join('districts', 'companies.district_id', '=', 'districts.id')
////            ->rightJoin('institutes', 'districts.id', '=', 'institutes.dist_id')
////            ->groupBy('institutes.id','institutes.institute_head_office')
//////            ->orderBy('institutes.id', 'ASC');
////            ->orderBy('job_count', 'DESC');
////        if (isset($data['apply_type'])) {
////            $jobQuery->where('trainee_applies.apply_type', $data['apply_type']);
////        }
////        //        dd($jobQuery->toSql());
////        return $jobQuery;
//        $jobQuery = $jobQuery->selectRaw("
//            institutes.id as id,
//            institutes.name as institute_name,
//            SUM(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE 0 END) as apply_count,
//            SUM(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE 0 END) as job_match_count,
//            institutes.institute_head_office AS institute_head_office
//        ")
//            ->join('trainee_applies', 'jobs.id', '=', 'trainee_applies.job_id')
//            ->join('companies', 'jobs.company_id', '=', 'companies.id')
//            ->join('districts', 'companies.district_id', '=', 'districts.id')
//            ->rightJoin('institutes', 'districts.id', '=', 'institutes.dist_id')
//            ->when(!empty($data['head_office']), function ($query) use ($data) {
//                $query->where('institutes.institute_head_office', $data['head_office']);
//            })
//            ->groupBy('institutes.id','institutes.institute_head_office')
//            ->orderBy('job_match_count', 'DESC');
//
//        if (!empty($data['apply_type'])) {
//            $jobQuery->where('trainee_applies.apply_type', $data['apply_type']);
//        }
//
//        return $jobQuery;
//    }
    private function applyInstituteQuery($jobQuery, $data)
    {
        return $jobQuery
            // 1. Select các thông tin cần thiết của Institute
            ->select([
                'institutes.id',
                'institutes.name as institute_name',
                'institutes.institute_head_office',
            ])
            // Đếm số lượng match dựa trên bảng trainee_matches
            ->selectRaw('COUNT(trainee_matches.id) as job_match_count')

            // 2. INNER JOIN trainee_matches
            // Logic: Lấy các Job có trong bảng match
            ->join('trainee_matches', 'jobs.id', '=', 'trainee_matches.job_id')

            // 3. INNER JOIN cgo_users
            // Logic: Tìm xem ai (CGO nào) là người tạo ra match này (created_by)
            ->join('cgo_users', 'trainee_matches.created_by', '=', 'cgo_users.id')

            // 4. INNER JOIN institutes
            // Logic: CGO đó thuộc về Institute nào
            ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')

            // 5. Bộ lọc Head Office (nếu có)
            ->when(!empty($data['head_office']), function ($query) use ($data) {
                $query->where('institutes.institute_head_office', $data['head_office']);
            })

            // 6. Group by để tính count
            ->groupBy(
                'institutes.id',
                'institutes.name',
                'institutes.institute_head_office'
            )

            // 7. Sắp xếp giảm dần theo số lượng match
            ->orderByDesc('job_match_count');
    }
    private function applyCompanyQuery($jobQuery, $data)
    {
//        $jobQuery->selectRaw("
//            MAX(company_recruiters.id) as id,
//            MAX(company_recruiters.first_name) as company_name,
//            jobs.company_id as company_id,
//            MAX(districts.name) as district_name,
//            COUNT(jobs.id) as job_posting_count,
//            COUNT(jobs.id) as job_apply,
//             COUNT(jobs.id) as job_matched,
//            SUM(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE 0 END) as apply_count,
//            SUM(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE 0 END) as job_match_count
//        ")
//            ->leftJoin('company_recruiters', 'jobs.created_by', '=', 'company_recruiters.id')
//            ->leftJoin('trainee_applies', 'jobs.id', '=', 'trainee_applies.job_id')
//            ->leftJoin('companies', 'company_recruiters.company_id', '=', 'companies.id')
//            ->leftJoin('districts', 'companies.district_id', '=', 'districts.id')
//            ->groupBy('jobs.company_id')
//            ->orderBy('company_name', 'ASC');
        $jobQuery->selectRaw("
    MAX(companies.id) as id,
    MAX(companies.name) as company_name,
    jobs.company_id as company_id,
    MAX(districts.name) as district_name,
    COUNT(DISTINCT jobs.id) as job_posting_count,
    COUNT(DISTINCT jobs.id) as job_apply,
    COUNT(DISTINCT jobs.id) as job_matched,
    SUM(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE 0 END) as apply_count,
    SUM(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE 0 END) as job_match_count
")
            ->leftJoin('companies', 'jobs.company_id', '=', 'companies.id')
            ->leftJoin('trainee_applies', 'jobs.id', '=', 'trainee_applies.job_id')
            ->leftJoin('districts', 'companies.district_id', '=', 'districts.id')
            ->groupBy('jobs.company_id')
            ->havingRaw('COUNT(DISTINCT jobs.id) > 0');

// Apply filters
        if (!empty($data['apply_type'])) {
            $jobQuery->where('trainee_applies.apply_type', $data['apply_type']);
        }
        if (!empty($data['sector_id'])) {
            $jobQuery->where('jobs.sector_id', $data['sector_id']);
        }

// Order by tùy điều kiện
        if (!empty($data['apply_type']) && $data['apply_type'] === 'job_match') {
            $jobQuery->orderBy('job_match_count', 'DESC');
        } elseif (!empty($data['apply_type']) && $data['apply_type'] === 'apply') {
            $jobQuery->orderBy('apply_count', 'DESC');
        } else {
            $jobQuery->orderBy('job_posting_count', 'DESC');
        }

        return $jobQuery;
    }
    private function applyQuery($jobQuery, $data)
    {
        $jobQuery = Job::query()->selectRaw("
                jobs.id,
                jobs.title,
                jobs.created_at as date,
                COUNT(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE NULL END) as appliesTypeApply,
                COUNT(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE NULL END) as appliesTypeMatch
            ")
            ->leftJoin('trainee_applies', 'jobs.id', '=', 'trainee_applies.job_id')
//            ->havingRaw("
//            COUNT(CASE WHEN trainee_applies.apply_type = 'apply' THEN 1 ELSE NULL END) > 0
//            OR
//            COUNT(CASE WHEN trainee_applies.apply_type = 'job_match' THEN 1 ELSE NULL END) > 0
//        ")
            ->groupBy('jobs.id', 'jobs.title', 'jobs.created_at')

            ;
        return $jobQuery;
    }

    private function applyKeywordSearch($jobQuery, $type, $keywords)
    {
        $keywords = strtolower($keywords);

        switch ($type) {
            case 'cgo':
                $jobQuery->whereRaw('LOWER(CONCAT(cgo_users.first_name, " ", cgo_users.last_name)) LIKE ?', ['%' . $keywords . '%']);
                break;

            case 'institute':
                $jobQuery->whereRaw('LOWER(institutes.name) LIKE ?', ['%' . $keywords . '%']);
                break;

            case 'company':
                $jobQuery->whereRaw('LOWER(companies.name) LIKE ?', ['%' . $keywords . '%']);
                break;
        }
    }
}
