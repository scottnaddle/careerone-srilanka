<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodeManagement extends Model
{
    use HasFactory;
    protected $fillable = ['code_id', 'code_name_en', 'code_name_tm', 'code_name_sn', 'module'];
    protected $table = 'code_managements';

    /**
     * Flush the cached code lookups (see getCodeList / getCodeNameByCodeId) whenever
     * a code record changes, so admin edits are reflected immediately.
     */
    protected static function booted(): void
    {
        $flush = function (self $code) {
            $module = strtolower((string) $code->module);
            foreach (['code_name_en', 'code_name_tm', 'code_name_sn'] as $col) {
                \Illuminate\Support\Facades\Cache::forget("codelist.{$module}.{$col}");
                \Illuminate\Support\Facades\Cache::forget("codename.{$module}.{$code->code_id}.{$col}");
            }
        };

        static::saved($flush);
        static::deleted($flush);
    }
    public function carrerTests()
    {
        return $this->hasMany(CareerTest::class, 'test_type', 'code_id');
    }

    public function countCarrerTestCodeId($date = null)
    {
        $memberCountQuery = $this->carrerTests()
                                 ->join('career_test_trainee_results', 'career_tests.id', '=', 'career_test_trainee_results.career_test_id')
                                 ->whereNotNull('career_test_trainee_results.trainee_id');
    
        $nonMemberCountQuery = $this->carrerTests()
                                    ->join('career_test_trainee_results', 'career_tests.id', '=', 'career_test_trainee_results.career_test_id')
                                    ->whereNull('career_test_trainee_results.trainee_id');
        if ($date) {
            $memberCountQuery->whereDate('career_test_trainee_results.created_at', $date);
            $nonMemberCountQuery->whereDate('career_test_trainee_results.created_at', $date);
        }
    
        $memberCount = $memberCountQuery->count('career_tests.id');
        $nonMemberCount = $nonMemberCountQuery->count('career_tests.id');
    
        return [
            'member' => $memberCount,
            'non_member' => $nonMemberCount,
        ];
    }
    
}
