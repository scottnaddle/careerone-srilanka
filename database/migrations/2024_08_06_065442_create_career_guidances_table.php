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
        Schema::create('career_guidances', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->integer('category_id');
            $table->string('thumbnail');
            $table->string('slug')->nullable(false);
            $table->longText('intro')->nullable();
            $table->string('video_url')->nullable();
            $table->string('system')->nullable();
            $table->integer('status')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('career_guidance_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_guidances');
    }
};
