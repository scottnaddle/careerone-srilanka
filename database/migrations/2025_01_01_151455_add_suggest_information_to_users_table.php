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
        Schema::table('cgo_counselings', function (Blueprint $table) {
            $table->text('suggested_institutes')->nullable();
            $table->text('suggested_nvq_courses')->nullable();
            $table->text('suggested_tvec_courses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cgo_counselings', function (Blueprint $table) {
            $table->dropColumn('suggested_institutes');
            $table->dropColumn('suggested_nvq_courses');
            $table->dropColumn('suggested_tvec_courses');
        });
    }
};
