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
        Schema::create('career_expert_interviews', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('thumbnail')->nullable();
            $table->string('slug')->nullable(false);
            $table->longText('intro')->nullable();
            $table->string('video_url')->nullable();
            $table->string('system')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_expert_interviews');
    }
};
