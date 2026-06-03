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
        Schema::create('q_n_a_s', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->longText('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('system');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_n_a_s');
    }
};
