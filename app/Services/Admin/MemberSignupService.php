<?php

namespace App\Services\Admin;

use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\TraineeUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AdminUser;
use App\Models\Company;
use App\Models\Content;
use App\Models\Event;
class MemberSignupService
{
    protected object $modelCgoUser;
    protected object $modelCompany;
    protected object $modelTraineeUser;

    /**
     * MemberSignup constructor.
     * @param CgoUser $modelCgoUser
     * @param Company $modelCompany
     * @param TraineeUser $modelTraineeUser
     */
    public function __construct(CgoUser $modelCgoUser, Company $modelCompany, TraineeUser $modelTraineeUser)
    {
        $this->modelCgoUser = $modelCgoUser;
        $this->modelCompany = $modelCompany;
        $this->modelTraineeUser = $modelTraineeUser;
    }

    public function getMemberSignupTableData(array $data = []): Builder
    {
        // Find the first registration date across all user tables
        $firstDate = DB::table('cgo_users')
            ->selectRaw('MIN(created_at) as first_date')
            ->unionAll(
                DB::table('company_recruiters')->selectRaw('MIN(created_at) as first_date')
            )
            ->unionAll(
                DB::table('trainee_users')->selectRaw('MIN(created_at) as first_date')
            )
            ->unionAll(
                DB::table('admin_users')->selectRaw('MIN(created_at) as first_date')
            )
            ->orderByRaw('first_date ASC')
            ->first()->first_date;

        // Override with filtered date if provided
        if (!empty($data['date'])) {
            $filterDate = Carbon::parse($data['date'])->startOfDay();
            $firstDate = $filterDate;
        }

        $firstDate = $firstDate ? Carbon::parse($firstDate)->startOfDay() : Carbon::today();
        $currentDate = Carbon::now()->startOfDay();

        // Create a proper subquery using a closure
        $subQuery = function ($query) {
            $query->select(DB::raw("
            DISTINCT DATE(created_at) as date,
            SUM(CASE WHEN user_type = 'cgo' THEN 1 ELSE 0 END) as cgo_total,
            SUM(CASE WHEN user_type = 'company' THEN 1 ELSE 0 END) as company_total,
            SUM(CASE WHEN user_type = 'trainee' THEN 1 ELSE 0 END) as trainee_total,
            SUM(CASE WHEN user_type = 'admin' THEN 1 ELSE 0 END) as admin_total,
            COUNT(*) as total_users
        "))
                ->from(function ($subQuery) {
                    $subQuery->select(DB::raw("created_at, 'cgo' as user_type"))
                        ->from('cgo_users')
                        ->unionAll(function ($q) {
                            $q->select(DB::raw("created_at, 'company' as user_type"))
                                ->from('company_recruiters');
                        })
                        ->unionAll(function ($q) {
                            $q->select(DB::raw("created_at, 'trainee' as user_type"))
                                ->from('trainee_users');
                        })
                        ->unionAll(function ($q) {
                            $q->select(DB::raw("created_at, 'admin' as user_type"))
                                ->from('admin_users');
                        });
                }, 'combined_users')
                ->groupBy(DB::raw("DATE(created_at)"))
                ->orderBy('date', 'asc');
        };

        $query = CgoUser::fromSub($subQuery, 'signup_data');

        return $query;
    }

//    public function getMemberSignupTableData(array $data = []): Builder
//    {
//        // Find the first registration date across all user tables
//        $firstDate = DB::table('cgo_users')
//            ->selectRaw('MIN(created_at) as first_date')
//            ->unionAll(
//                DB::table('company_recruiters')->selectRaw('MIN(created_at) as first_date')
//            )
//            ->unionAll(
//                DB::table('trainee_users')->selectRaw('MIN(created_at) as first_date')
//            )
//            ->unionAll(
//                DB::table('admin_users')->selectRaw('MIN(created_at) as first_date')
//            )
//            ->orderByRaw('first_date ASC')
//            ->first()->first_date;
//
//        // Override with filtered date if provided
//        if (!empty($data['date'])) {
//            $filterDate = Carbon::parse($data['date'])->startOfDay();
//            $firstDate = $filterDate;
//        }
//
//        $firstDate = $firstDate ? Carbon::parse($firstDate)->startOfDay() : Carbon::today();
//        $currentDate = Carbon::now()->startOfDay();
//
//        // Create a proper subquery using a closure
//        $subQuery = function ($query) {
//            $query->select(DB::raw("
//                DATE(created_at) as date,
//                SUM(CASE WHEN user_type = 'cgo' THEN 1 ELSE 0 END) as cgo_total,
//                SUM(CASE WHEN user_type = 'company' THEN 1 ELSE 0 END) as company_total,
//                SUM(CASE WHEN user_type = 'trainee' THEN 1 ELSE 0 END) as trainee_total,
//                SUM(CASE WHEN user_type = 'admin' THEN 1 ELSE 0 END) as admin_total,
//                COUNT(*) as total_users
//            "))
//            ->from(function ($subQuery) {
//                $subQuery->select(DB::raw("created_at, 'cgo' as user_type"))
//                    ->from('cgo_users')
//                    ->unionAll(function ($q) {
//                        $q->select(DB::raw("created_at, 'company' as user_type"))
//                            ->from('company_recruiters');
//                    })
//                    ->unionAll(function ($q) {
//                        $q->select(DB::raw("created_at, 'trainee' as user_type"))
//                            ->from('trainee_users');
//                    })
//                    ->unionAll(function ($q) {
//                        $q->select(DB::raw("created_at, 'admin' as user_type"))
//                            ->from('admin_users');
//                    });
//            }, 'combined_users')
//            ->groupBy('date')
//            ->orderBy('date', 'asc');
//        };
//
//        $query = CgoUser::fromSub($subQuery, 'signup_data');
//
//        return $query;
//    }





}
