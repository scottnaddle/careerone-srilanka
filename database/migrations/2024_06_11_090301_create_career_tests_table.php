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
        Schema::create('career_tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_name')->nullable(false);
            $table->json('content')->nullable();
            $table->string('test_type',2)->default(0);
            $table->longText('description')->nullable();
            $table->string('link')->nullable();
            $table->string('status')->nullable();
            $table->string('expired_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_tests');
    }
};
