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
        Schema::create('custom_job_queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue');                
            $table->longText('payload');           
            $table->unsignedTinyInteger('attempts');
            $table->string('reserved_at')->nullable(); 
            $table->string('available_at');    
            $table->unsignedInteger('created_at');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_job_queues');
    }
};
