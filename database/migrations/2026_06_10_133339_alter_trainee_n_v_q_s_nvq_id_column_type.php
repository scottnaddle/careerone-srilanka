<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if ($driver === 'pgsql') {
            $colType = DB::selectOne("
                SELECT data_type 
                FROM information_schema.columns 
                WHERE table_name = 'trainee_n_v_q_s' AND column_name = 'nvq_id'
            ");
            
            if ($colType && in_array(strtolower($colType->data_type), ['character varying', 'text', 'varchar'])) {
                DB::statement("ALTER TABLE trainee_n_v_q_s ALTER COLUMN nvq_id TYPE bigint USING NULLIF(regexp_replace(nvq_id, '\D', '', 'g'), '')::bigint");
            }
        } else {
            Schema::table('trainee_n_v_q_s', function (Blueprint $table) {
                $table->unsignedBigInteger('nvq_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if ($driver === 'pgsql') {
            $colType = DB::selectOne("
                SELECT data_type 
                FROM information_schema.columns 
                WHERE table_name = 'trainee_n_v_q_s' AND column_name = 'nvq_id'
            ");
            
            if ($colType && strtolower($colType->data_type) === 'bigint') {
                DB::statement('ALTER TABLE trainee_n_v_q_s ALTER COLUMN nvq_id TYPE varchar(30)');
            }
        } else {
            Schema::table('trainee_n_v_q_s', function (Blueprint $table) {
                $table->string('nvq_id', 30)->nullable()->change();
            });
        }
    }
};
