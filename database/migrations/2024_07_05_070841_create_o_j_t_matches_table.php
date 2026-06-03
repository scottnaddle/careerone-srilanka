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
        Schema::create('o_j_t_matches', function (Blueprint $table) {
            $table->id();
            $table->integer('trainee_id');
            $table->integer('ojt_id');
            $table->timestamp('matched_time');
            $table->integer('matched_by');
            $table->string('system');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('o_j_t_matches');
    }
};
