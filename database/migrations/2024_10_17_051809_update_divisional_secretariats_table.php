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
        // Recreate the divisional_secretariats table with the updated structure
        Schema::create('divisional_secretariats', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('ds_code')->unique(); // Unique DS code
            $table->string('ds_name'); // DS name
            $table->string('dist_id')->nullable(false); // District ID, not nullable
            $table->timestamps(); // Created at and Updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table if rolling back the migration
        Schema::dropIfExists('divisional_secretariats');
    }
};
