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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->string('event_type', 2);
            $table->string('slug');
            $table->string('place')->nullable();
            $table->longText('details');
            $table->string('thumbnail');
            $table->date('start_time');
            $table->date('end_time');
            $table->string('system');
            $table->integer('status');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
