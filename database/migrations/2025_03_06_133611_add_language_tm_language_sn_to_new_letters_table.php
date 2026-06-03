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
        Schema::table('new_letters', function (Blueprint $table) {
            $table->string('title_tm')->nullable();
            $table->string('title_sn')->nullable();
            $table->string('description_tm')->nullable();
            $table->string('description_sn')->nullable();
            $table->string('attachment_tm')->nullable();
            $table->string('attachment_sn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_letters', function (Blueprint $table) {
            $table->dropColumn('title_tm');
            $table->dropColumn('title_sn');
            $table->dropColumn('description_tm');
            $table->dropColumn('description_sn');
            $table->dropColumn('attachment_tm');
            $table->dropColumn('attachment_sn');
        });
    }
};
