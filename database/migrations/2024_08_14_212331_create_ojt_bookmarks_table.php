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
        Schema::create('ojt_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->integer('trainee_id');
            $table->integer('ojt_id');

            $table->foreign('trainee_id')->references('id')->on('trainee_users')->onDelete('cascade');
            $table->foreign('ojt_id')->references('id')->on('o_j_t_s')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ojt_bookmarks');
    }
};
