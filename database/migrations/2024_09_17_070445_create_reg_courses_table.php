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
        Schema::create('reg_courses', function (Blueprint $table) {
            $table->id();
            $table->string('institute_reg_no',10);
            $table->string('institute_name',250);
            $table->string('district_code',3);
            $table->string('course_id',20);
            $table->string('course_name',250);
            $table->float('course_duration');
            $table->string('course_mode',20);
            $table->string('course_medium',20);
            $table->string('entry_qualification',150);
            $table->string('industry_sector',150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_courses');
    }
};
