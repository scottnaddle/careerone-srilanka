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
        Schema::create('code_managements', function (Blueprint $table) {
            $table->id();
            $table->string('code_name_en')->nullable();
            $table->string('code_name_tm')->nullable();
            $table->string('code_name_sn')->nullable();
            $table->integer('code_id')->default(0);
            $table->string('module')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->unique(['module', 'code_id'], 'unique_module_code_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_managements');
    }
};
