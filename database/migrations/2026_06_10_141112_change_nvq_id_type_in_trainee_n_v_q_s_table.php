<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For PostgreSQL specifically to cast the varchar to bigint safely
        \DB::statement('ALTER TABLE trainee_n_v_q_s ALTER COLUMN nvq_id TYPE bigint USING nvq_id::bigint');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement('ALTER TABLE trainee_n_v_q_s ALTER COLUMN nvq_id TYPE varchar(30) USING nvq_id::varchar');
    }
};
