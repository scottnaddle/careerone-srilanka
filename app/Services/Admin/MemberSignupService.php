<?php

namespace App\Services\Admin;

use App\Models\CgoUser;
use App\Models\TraineeUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class MemberSignupService {
    protected object $modelCgoUser;
    protected object $modelCompany;
    protected object $modelTraineeUser;

    /**
     * MemberSignup constructor.
     * @param CgoUser $modelCgoUser
     * @param Company $modelCompany
     * @param TraineeUser $modelTraineeUser
     */
    public function __construct(CgoUser $modelCgoUser, Company $modelCompany, TraineeUser $modelTraineeUser) {
        $this->modelCgoUser = $modelCgoUser;
        $this->modelCompany = $modelCompany;
        $this->modelTraineeUser = $modelTraineeUser;
    }

    public function getMemberSignupTableData(bool $isAdmin = false, ?array $instituteIds = null): Builder {
        if ($isAdmin) {
            // For admin: query cgo and trainee with institute filter
            $cgoQuery = DB::table('cgo_users')
                ->select(DB::raw("DATE(created_at) as date, COUNT(*) as cgo_total"))
                ->whereNotNull('created_at')
                ->groupBy(DB::raw("DATE(created_at)"));

            if (!empty($instituteIds)) {
                $cgoQuery->whereIn('institute_id', $instituteIds);
            }

            $traineeQuery = DB::table('trainee_users')
                ->select(DB::raw("DATE(trainee_users.created_at) as date, COUNT(*) as trainee_total"))
                ->whereNotNull('trainee_users.created_at')
                ->groupBy(DB::raw("DATE(trainee_users.created_at)"));

            if (!empty($instituteIds)) {
                $traineeQuery->join('trainee_institutes', 'trainee_users.id', '=', 'trainee_institutes.trainee_id')
                    ->whereIn('trainee_institutes.institute_id', $instituteIds);
            }

            // Use raw SQL for PostgreSQL compatibility
            $query = CgoUser::from(DB::raw("(
                SELECT
                    COALESCE(c.date, t.date) as date,
                    COALESCE(c.cgo_total, 0) as cgo_total,
                    0 as company_total,
                    COALESCE(t.trainee_total, 0) as trainee_total,
                    0 as admin_total,
                    (COALESCE(c.cgo_total, 0) + COALESCE(t.trainee_total, 0)) as total_users
                FROM ({$cgoQuery->toSql()}) c
                FULL OUTER JOIN ({$traineeQuery->toSql()}) t ON c.date = t.date
                ORDER BY date ASC
            ) as signup_data"), array_merge($cgoQuery->getBindings(), $traineeQuery->getBindings()));

        } else {
            // For super admin: query all user types
            $allUsersQuery = DB::table('cgo_users')
                ->select(DB::raw("created_at, 'cgo' as user_type"))
                ->unionAll(
                    DB::table('company_recruiters')->select(DB::raw("created_at, 'company' as user_type"))
                )
                ->unionAll(
                    DB::table('trainee_users')->select(DB::raw("created_at, 'trainee' as user_type"))
                )
                ->unionAll(
                    DB::table('admin_users')->select(DB::raw("created_at, 'admin' as user_type"))
                );

            $query = CgoUser::from(DB::raw("(
                SELECT
                    DATE(created_at) as date,
                    SUM(CASE WHEN user_type = 'cgo' THEN 1 ELSE 0 END) as cgo_total,
                    SUM(CASE WHEN user_type = 'company' THEN 1 ELSE 0 END) as company_total,
                    SUM(CASE WHEN user_type = 'trainee' THEN 1 ELSE 0 END) as trainee_total,
                    SUM(CASE WHEN user_type = 'admin' THEN 1 ELSE 0 END) as admin_total,
                    COUNT(*) as total_users
                FROM ({$allUsersQuery->toSql()}) combined_users
                WHERE created_at IS NOT NULL
                GROUP BY DATE(created_at)
                ORDER BY date ASC
            ) as signup_data"), $allUsersQuery->getBindings());
        }

        return $query;
    }
}
