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
        Schema::create('q_n_a_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('qna_id')->nullable();
            $table->longText('answer');
            $table->string('system');
            $table->integer('answer_by');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_n_a_answers');
    }
};
