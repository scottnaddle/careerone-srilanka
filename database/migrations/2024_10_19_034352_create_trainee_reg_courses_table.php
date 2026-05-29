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
        Schema::create('trainee_reg_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainee_id')->nullable();
            $table->unsignedBigInteger('reg_course_id')->nullable();
            $table->string('batch_no', 30)->nullable();
            $table->string('start_date', 10)->nullable();
            $table->string('end_date', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_reg_courses');
    }
};
