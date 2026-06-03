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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('content_type',10)->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->longText('intro')->nullable();
            $table->string('video_url')->nullable();
            $table->json('attachment_details')->nullable();
            $table->string('author')->nullable();
            $table->string('license')->nullable();
            $table->string('system')->nullable(false);
            $table->tinyInteger('status')->nullable(false);
            $table->string('size')->nullable();
            $table->integer('created_by')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
