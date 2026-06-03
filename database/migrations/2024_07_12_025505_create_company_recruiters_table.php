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
        Schema::create('company_recruiters', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable(false);
            $table->string('first_name',60)->nullable(false);
            $table->string('last_name',60)->nullable(false);
            $table->string('email',150)->nullable(false)->unique();
            $table->string('username',100)->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('telephone',20)->nullable(false);
            $table->string('profile_image')->nullable();
            $table->timestamp('verify_at')->nullable();
            $table->unsignedInteger('verify_by')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_recruiters');
    }
};
