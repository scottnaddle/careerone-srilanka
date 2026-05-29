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
        Schema::table('newsletter_categories', function (Blueprint $table) {
            $table->string('name_tm')->nullable();
            $table->string('name_sn')->nullable();
            $table->string('description_tm')->nullable();
            $table->string('description_sn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_categories', function (Blueprint $table) {
            $table->dropColumn('name_tm');
            $table->dropColumn('name_sn');
            $table->dropColumn('description_tm');
            $table->dropColumn('description_sn');
        });
    }
};
