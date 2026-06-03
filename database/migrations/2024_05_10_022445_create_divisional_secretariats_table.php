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
        Schema::create('divisional_secretariats', function (Blueprint $table) {
            $table->id();
            $table->string('ds_code',10)->unique();
            $table->string('ds_name',100);
            $table->string('dist_id',3)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::table('divisional_secretariats', function(Blueprint $table)
//        {
//            $table->dropForeign('divisional_secretariats_dist_id_foreign');
//            $table->dropColumn('dist_id');
//        });
        Schema::dropIfExists('divisional_secretariats');
    }
};
