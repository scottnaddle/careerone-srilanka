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
        Schema::create('ojt_trainee_applies', function (Blueprint $table) {
            $table->id();
            $table->integer('ojt_id');
            $table->integer('trainee_id');
            $table->timestamp('apply_time');
            $table->timestamp('read')->nullable();
            $table->timestamp('selected')->nullable();
            $table->timestamp('employeed')->nullable();
            $table->integer('selected_by')->nullable();
            $table->string('apply_type');
            $table->timestamps();


            $table->foreign('ojt_id')->references('id')->on('o_j_t_s')->onDelete('cascade');
            $table->foreign('trainee_id')->references('id')->on('trainee_users')->onDelete('cascade');
            $table->foreign('selected_by')->references('id')->on('company_recruiters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ojt_trainee_applies');
    }
};
