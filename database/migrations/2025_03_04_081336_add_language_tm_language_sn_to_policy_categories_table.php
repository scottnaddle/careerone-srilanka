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
        Schema::table('policy_categories', function (Blueprint $table) {
            $table->string("name_sn")->nullable();
            $table->string("name_tm")->nullable();
            $table->string("description_sn")->nullable();
            $table->string("description_tm")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policy_categories', function (Blueprint $table) {
            //
        });
    }
};
