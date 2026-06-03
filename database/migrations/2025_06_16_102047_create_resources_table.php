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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('content_type',10)->nullable(false);
            $table->string('title')->nullable(false);
            $table->longText('intro')->nullable();
            $table->string('video_url')->nullable();
            $table->string('attachment_details')->nullable();
            $table->integer('created_by')->nullable(false);
            $table->string('system')->nullable(false);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
