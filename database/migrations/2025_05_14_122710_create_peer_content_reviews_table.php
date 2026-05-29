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
        Schema::create('peer_content_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_id');
            $table->unsignedBigInteger('cgo_user_id_1')->nullable();
            $table->unsignedBigInteger('cgo_user_id_2')->nullable();
            $table->unsignedBigInteger('cgo_user_id_3')->nullable();
            $table->float('cgo_user_1_result')->nullable();
            $table->float('cgo_user_2_result')->nullable();
            $table->float('cgo_user_3_result')->nullable();
            $table->text('cgo_user_1_result_details')->nullable();
            $table->text('cgo_user_2_result_details')->nullable();
            $table->text('cgo_user_3_result_details')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_content_reviews');
    }
};
