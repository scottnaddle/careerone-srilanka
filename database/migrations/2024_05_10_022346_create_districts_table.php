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
        Schema::create('districts', function (Blueprint $table) {
            $table->string('id',3)->primary();
            $table->string('name',100)->nullable(false);
            $table->string('prov_id', 3)->nullable(false);
            $table->foreign('prov_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::table('districts', function($table)
//        {
//            $table->dropForeign('districts_prov_id_foreign');
//            $table->dropColumn('prov_id');
//        });
        Schema::dropIfExists('districts');
    }
};
