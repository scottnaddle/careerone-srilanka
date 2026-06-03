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
        Schema::create('nvq_qualifications', function (Blueprint $table) {
            $table->id(); 
            $table->string('nvq_id',30);
            $table->string('nvq_name',200);
            $table->string('nvq_level',200);
            $table->string('ncs_code',200);
            $table->string('ncs_name',200);
            $table->string('version',3);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvq_qualifications');
    }
};
