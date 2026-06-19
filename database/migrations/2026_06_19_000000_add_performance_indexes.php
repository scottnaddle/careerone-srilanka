<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Adds indexes to hot, frequently-filtered columns that previously had none.
 * Uses Postgres `IF NOT EXISTS` so the migration is idempotent and safe to
 * re-run / run against environments where some indexes may already exist.
 */
return new class extends Migration
{
    /**
     * @var array<int, array{0:string,1:string}> [index name, CREATE INDEX body]
     */
    private array $indexes = [
        // jobs: every listing filters status; sector_id/created_by are joined/filtered.
        ['idx_jobs_status', 'ON jobs (status)'],
        ['idx_jobs_sector_id', 'ON jobs (sector_id)'],
        ['idx_jobs_created_by', 'ON jobs (created_by)'],

        // trainee_applies: backs the per-job apply/match/unread/shortlist counts.
        ['idx_trainee_applies_job_trainee_type', 'ON trainee_applies (job_id, trainee_id, apply_type)'],
        ['idx_trainee_applies_apply_type', 'ON trainee_applies (apply_type)'],

        // cgo_counselings: dashboards and homepage filter by status / field.
        ['idx_cgo_counselings_status', 'ON cgo_counselings (status)'],
        ['idx_cgo_counselings_field_id', 'ON cgo_counselings (counseling_field_id)'],

        // contents: listings filter by system+status, author and category.
        ['idx_contents_system_status', 'ON contents (system, status)'],
        ['idx_contents_created_by', 'ON contents (created_by)'],
        ['idx_contents_category_id', 'ON contents (category_id)'],
    ];

    public function up(): void
    {
        foreach ($this->indexes as [$name, $body]) {
            DB::statement("CREATE INDEX IF NOT EXISTS {$name} {$body}");
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as [$name]) {
            DB::statement("DROP INDEX IF EXISTS {$name}");
        }
    }
};
