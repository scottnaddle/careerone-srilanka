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
        Schema::create('career_test_trainee_results', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('nic')->nullable();
            $table->integer('trainee_id')->nullable();
            $table->integer('career_test_id')->nullable();
            $table->string('test_type', 2)->nullable();
            $table->text('result')->nullable();
            $table->text('attachment')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_test_trainee_results');
    }
};
