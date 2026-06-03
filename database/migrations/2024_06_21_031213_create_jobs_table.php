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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('job_type', 2);
            $table->integer('sector_id');
            $table->integer('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('working_day', 255)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->string('start_time', 20)->nullable();
            $table->string('end_time', 20)->nullable();
            $table->float('min_salary')->nullable();
            $table->float('max_salary')->nullable();
			$table->boolean('discussion_salary')->default(false);
            $table->string('gender',50);
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
			$table->boolean('not_limit_age')->default(false);
            $table->text('min_work_experience')->nullable();
            $table->text('max_work_experience')->nullable();
			$table->boolean('not_limit_experience')->default(false);
            $table->text('required_skills')->nullable();
            $table->timestamp('application_starttime')->nullable();
            $table->timestamp('application_endtime')->nullable();
            $table->string('slug')->nullable();
            $table->string('hr_name', 255)->nullable();
            $table->string('hr_email', 150)->nullable();
            $table->longText('hr_contact_info')->nullable();
            $table->longText('roles')->nullable();
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('job_location')->nullable();
            $table->integer('number_of_recruitments')->nullable();
            $table->string('salary_currency','4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
