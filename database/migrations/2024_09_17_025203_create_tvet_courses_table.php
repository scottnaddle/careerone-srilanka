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
        Schema::create('tvet_courses', function (Blueprint $table) {
            $table->id();
            $table->string('district_code',3); 
            $table->string('training_provider');
            $table->string('tvec_registration_number'); 
            $table->string('institute_name'); 
            $table->string('course_code'); 
            $table->string('course_name'); 
            $table->string('nvq_level');
            $table->string('duration'); 
            $table->string('mode'); 
            $table->string('medium');
            $table->string('entry_qualification');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvet_courses');
    }
};
