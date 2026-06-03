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
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable(false);
            // $table->string('detail')->nullable();
            $table->string('phone', 40)->nullable(false);
            $table->string('fax', 15)->nullable();
            $table->string('prov_id', 3)->nullable();
            $table->string('dist_id', 4)->nullable();
            $table->string('ds_id', 4)->nullable();
            $table->string('valid_from', 10)->nullable();
            $table->string('valid_to', 10)->nullable();
            $table->string('reg_no', 10)->nullable();
            $table->integer('created_by')->nullable();
            $table->string('address', 200)->nullable();
            $table->string('district_name')->nullable();

            $table->string('ownership', 50)->nullable();
            $table->string('active_status', 100)->default('active');
            $table->string('institute_head_office')->nullable();
            //            $table->foreign('prov_id')->references('id')->on('provinces')->onDelete('cascade');
            //            $table->foreign('dist_id')->references('id')->on('districts')->onDelete('cascade');
            //            $table->foreign('ds_id')->references('id')->on('divisional_secretariats')->onDelete('cascade');
            //            $table->foreign('created_by')->references('id')->on('admin_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //        Schema::table('institutes', function($table)
        //        {
        //            $table->dropForeign('institutes_prov_id_foreign');
        //            $table->dropForeign('institutes_dist_id_foreign');
        //            $table->dropForeign('institutes_ds_id_foreign');
        //            $table->dropForeign('institutes_admin_id_foreign');
        //            $table->dropColumn('prov_id');
        //            $table->dropColumn('dist_id');
        //            $table->dropColumn('ds_id');
        //            $table->dropColumn('admin_id');
        //        });
        Schema::dropIfExists('institutes');
    }
};
