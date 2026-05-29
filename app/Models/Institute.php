<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Institute extends Model
{
    use HasFactory;

    protected $table = 'institutes';
    protected $fillable = [
        'name',
        'detail',
        'phone',
        'fax',
        'prov_id',
        'dist_id',
        'ds_id',
        'valid_form',
        'valid_to',
        'reg_no',
        'created_by'
    ];
    // protected static function booted()
    // {
    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('active_status', 'Active');
    //     });
    // }
    public function cgoUser()
    {
        return $this->hasMany(CgoUser::class, 'institute_id', 'id');
    }

    public function cgoCounseling()
    {
        return $this->hasMany(CgoCounseling::class, 'institute_id', 'id');
    }

    public function trainees()
    {
        return $this->hasMany(TraineeUser::class);
    }
    public function getTotalCarrertestByTestId($data) {}
    // public function district() {
    //     return $this->hasMany(TraineeUser::class);
    // }

    public function district()
    {
        return $this->belongsTo(District::class, 'dist_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'prov_id', 'id');
    }

    public function divisionalSecretariat()
    {
        return $this->belongsTo(DivisionalSecretariats::class, 'ds_id', 'ds_code');
    }
    public function tvetType()
    {
        return $this->belongsTo(TvetType::class, 'institute_head_office', 'head_office_code');
    }
    public function carrerTestsTraineeResult()
    {
        return $this->hasMany(CareerTestTraineeResult::class);
    }
    public function countCareerTestByInstitute($startDate = null, $endDate = null, $test_type)
    {
        // Base query
        $query = $this->carrerTestsTraineeResult()
            ->join('career_tests', 'career_tests.id', '=', 'career_test_trainee_results.career_test_id')
            ->where('career_tests.test_type', '=', $test_type);

        // Apply date filters
        if (!empty($startDate)) {
            $query->whereDate('career_test_trainee_results.created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $query->whereDate('career_test_trainee_results.created_at', '<=', $endDate);
        }

        // Count for members (trainee_id is not null)
        $memberCount = (clone $query)
            ->whereNotNull('career_test_trainee_results.trainee_id')
            ->count('career_test_trainee_results.id');

        // Count for non-members (trainee_id is null)
        $nonMemberCount = (clone $query)
            ->whereNull('career_test_trainee_results.trainee_id')
            ->count('career_test_trainee_results.id');

        return [
            'member' => $memberCount,
            'non_member' => $nonMemberCount,
        ];
    }
    public function countCareerTestByInstituteMember($startDate = null, $endDate = null)
    {
        // Base query without trainee_id condition
        $baseQuery = $this->carrerTestsTraineeResult()
            ->join('career_tests', 'career_tests.id', '=', 'career_test_trainee_results.career_test_id');

        // Apply date filters if provided
        if (!empty($startDate)) {
            $baseQuery->whereDate('career_test_trainee_results.created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $baseQuery->whereDate('career_test_trainee_results.created_at', '<=', $endDate);
        }

        // Count for members (trainee_id is NOT NULL)
        $memberCount = (clone $baseQuery)
            ->whereNotNull('career_test_trainee_results.trainee_id')
            ->count('career_test_trainee_results.id');

        // Count for non-members (trainee_id is NULL)
        $nonMemberCount = (clone $baseQuery)
            ->whereNull('career_test_trainee_results.trainee_id')
            ->count('career_test_trainee_results.id');

        return [
            'member' => $memberCount,
            'non_member' => $nonMemberCount,
        ];
    }
}
