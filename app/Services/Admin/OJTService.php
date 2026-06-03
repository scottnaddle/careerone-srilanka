<?php

namespace App\Services\Admin;

use App\Enums\JobStatusEnum;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\Institute;
use App\Models\OJT;
use Filament\Forms\Components\Builder;
use Illuminate\Support\Facades\DB;

class OJTService
{
    protected object $model;

    /**
     * JobService constructor.
     * @param Job $model
     */
    public function __construct(OJT $model)
    {
        $this->model = $model;
    }

    public function getAllJob(array $data = [])
    {
        // dd($data);
        $ojtQuery = $this->model->query();
        if (isset($data['sector'])) {
            $ojtQuery->where('sector_id', $data['sector']);
        }

        if (isset($data['district'])) {
            $district = $data['district'];
            $ojtQuery->whereHas('company', function ($query) use ($district) {
                $query->where('district', $district);
            })->get();
        }

        if (isset($data['start']) && isset($data['end'])) {
            $datefrom = $data['start'];
            $dateto = $data['end'];
            $ojtQuery->where(function ($query) use ($datefrom, $dateto) {
                $query->whereBetween('application_starttime', array($datefrom, $dateto));
            });
        }

        if (isset($data['status'])) {
            $query = $data['status'] === 'oldest' ? 'asc' : 'desc';
            // dd($query);
            $ojtQuery->orderBy('application_starttime', $query);
        }

        return $ojtQuery;
    }
    public function getMatchedOJT($type = null, $data = [])
    {
        if ($type == 'cgo') {
            $query = CgoUser::query()
                ->leftJoin('ojt_trainee_applies', function ($join) {
                    $join->on('cgo_users.id', '=', DB::raw('ojt_trainee_applies.matched_by::bigint'));
                })
                ->leftJoin('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->selectRaw("
        cgo_users.id AS id,
        cgo_users.first_name AS first_name,
        cgo_users.last_name AS last_name,
        institutes.institute_head_office AS institute_head_office,
        COUNT(ojt_trainee_applies.id) AS total_matches
    ")
                ->groupBy(
                    'cgo_users.id',
                    'institutes.institute_head_office',
                    'cgo_users.first_name',
                    'cgo_users.last_name'
                )
                ->havingRaw("COUNT(ojt_trainee_applies.id) > 0")
                ->when(!empty($data['head_office']), function ($q) use ($data) {
                    $q->where('institutes.institute_head_office', $data['head_office']);
                })
                ->orderBy('total_matches', 'desc');
        } else if ($type == 'company') {
//            $query = CompanyRecruiter::query()
//            ->leftJoin('o_j_t_s', function ($join) {
//                $join->on('o_j_t_s.created_by', '=', 'company_recruiters.id')
//                     ->where('o_j_t_s.system', '=', 'company');
//            })
//            ->leftJoin('o_j_t_matches', 'o_j_t_s.id', '=', 'o_j_t_matches.ojt_id')
//            ->leftJoin('companies', 'companies.id', '=', 'company_recruiters.company_id')
//            ->leftJoin('districts', 'districts.id', '=', 'companies.district_id')
//            ->selectRaw("
//                company_recruiters.id as id,
//                company_recruiters.first_name as first_name,
//                company_recruiters.last_name as last_name,
//                districts.name as district,
//                COUNT(o_j_t_matches.id) as matched_job
//            ")
//            ->groupBy(
//                'company_recruiters.id',
//                'company_recruiters.first_name',
//                'company_recruiters.last_name',
//                'districts.name'
//            );
            $query = Company::query()
                ->leftJoin('o_j_t_s', function ($join) {
                    $join->on('o_j_t_s.company_id', '=', 'companies.id')
                        ->where('o_j_t_s.system', '=', 'company');
                })
                ->leftJoin('ojt_trainee_applies', function ($join) {
                    $join->on('o_j_t_s.id', '=', 'ojt_trainee_applies.ojt_id')
                        ->where('ojt_trainee_applies.apply_type', '=', 'ojt_match');
                })
                ->leftJoin('districts', 'districts.id', '=', 'companies.district_id')
                ->selectRaw("
                    companies.id as id,
                    companies.name,
                    districts.name as district,
                    COUNT(ojt_trainee_applies.id) as matched_ojt
                ")
                ->groupBy(
                    'companies.id',
                    'companies.name',
                    'districts.name'
                )
                ->having(DB::raw('COUNT(ojt_trainee_applies.id)'), '>', 0)
                ->orderByDesc('matched_ojt');


        }else if($type == 'institute'){
            $query = Institute::query()
            ->where('active_status', 'ILIKE', 'Active')
            ->leftJoin('cgo_users', 'cgo_users.institute_id', '=', 'institutes.id')
            ->leftJoin('o_j_t_matches', 'cgo_users.id', '=', 'o_j_t_matches.matched_by')
            ->selectRaw("
                institutes.id AS id,
                institutes.name AS name,
                institutes.institute_head_office AS institute_head_office,
                COUNT(o_j_t_matches.id) AS total_matches
            ")
            ->groupBy('institutes.id', 'institutes.institute_head_office', 'institutes.name')
            ->havingRaw("COUNT(o_j_t_matches.id) > 0")
                ->when(!empty($data['head_office']), function ($q) use ($data) {
                    $q->where('institutes.institute_head_office', $data['head_office']);
                })
                ->orderBy('total_matches', 'desc');

        }
        return $query;
    }
}
