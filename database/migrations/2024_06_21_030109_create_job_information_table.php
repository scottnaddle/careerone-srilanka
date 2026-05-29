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
        Schema::create('job_information', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->integer('sector_id')->nullable(false);
            $table->longText('description')->nullable();
            $table->text('knowledge')->nullable();
            $table->text('skills')->nullable();
            $table->text('duties_of_the_job')->nullable();
            $table->text('related_occupations')->nullable();
            $table->text('benefits')->nullable();
            $table->text('expected_income_per_month')->nullable();
            $table->integer('created_by')->nullable(false);
            $table->text('attachment_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_information');
    }
};
