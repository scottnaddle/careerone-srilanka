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
        Schema::create('o_j_t_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('ojt_id');
            $table->string('file_name');
            $table->string('path');
            $table->string('file_type',2);
            $table->string('file_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('o_j_t_attachments');
    }
};
