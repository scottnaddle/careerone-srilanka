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
        Schema::create('o_j_t_s', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('gender',50);
            $table->unsignedBigInteger('company_id');
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->boolean('age_limitation')->nullable()->nullable()->default(false);
            $table->string('period')->nullable();
            $table->integer('number_of_recruitments')->nullable();
            $table->string('min_work_experience')->nullable();
            $table->string('max_work_experience')->nullable();
            $table->boolean('work_experience_limitation')->nullable()->default(false);
            $table->text('required_skills')->nullable();
            $table->timestamp('application_starttime')->nullable();
            $table->timestamp('application_endtime')->nullable();
            $table->timestamp('registration_date')->nullable();
            $table->string('slug');
            $table->string('hr_name',)->nullable();
            $table->string('hr_email', 150)->nullable();
            $table->longText('hr_contact_info')->nullable();
            $table->integer('status');
            $table->integer('created_by');
            $table->string('system', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('o_j_t_s');
    }
};
