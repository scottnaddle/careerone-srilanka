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
        Schema::table('ojt_trainee_applies', function (Blueprint $table) {
            $table->string('matched_by')->nullable();
            $table->string('apply_type', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ojt_trainee_applies', function (Blueprint $table) {
            $table->dropColumn('matched_by');
            $table->string('apply_type', 2)->change();
        });
    }
};
