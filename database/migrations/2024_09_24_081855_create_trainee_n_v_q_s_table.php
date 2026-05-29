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
        Schema::create('trainee_n_v_q_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainee_id')->nullable();
            $table->string('nvq_id',30)->nullable();
            $table->string('effective_date', 10)->nullable();
            $table->string('course_mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_n_v_q_s');
    }
};
