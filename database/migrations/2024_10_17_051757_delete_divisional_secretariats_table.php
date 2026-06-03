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
        // Drop the existing divisional_secretariats table
        Schema::dropIfExists('divisional_secretariats');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You can recreate the table if needed
        Schema::create('divisional_secretariats', function (Blueprint $table) {
            $table->string('id', 30)->primary();
            $table->string('ds_code')->unique();
            $table->string('ds_name');
            $table->string('dist_id')->nullable(false);
            $table->timestamps();
        });
    }
};
