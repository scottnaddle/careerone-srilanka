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
        Schema::create('cgo_counseling_assign_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('counseling_id');
            $table->json('assignee_from')->nullable()->comment('List of previous assignees');
            $table->bigInteger('assignee_to');
            $table->integer('time')->comment('How many times this counseling has been assigned');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cgo_counseling_assign_histories');
    }
};
