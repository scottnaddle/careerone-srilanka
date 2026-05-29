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
        Schema::create('nvq_courses', function (Blueprint $table) {
            $table->id(); 
            $table->string('course_id',20);
            $table->string('course_name',250)->nullable(); 
            $table->string('level',100); 
            $table->string('reg_no',10);
            $table->string('ncs_code',30);
            $table->string('ncs_name',200);
            $table->string('industry_sector',150)->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvq_courses');
    }
};
