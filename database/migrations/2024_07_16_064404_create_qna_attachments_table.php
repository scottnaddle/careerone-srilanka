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
        Schema::create('qna_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qna_id');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('path');
            $table->string('file_size');
            $table->timestamps();

            $table->foreign('qna_id')->references('id')->on('q_n_a_s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qna_attachments');
    }
};
