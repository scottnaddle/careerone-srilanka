<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Allow NULL nic for social login users (Google OAuth)
        Schema::table('trainee_users', function (Blueprint $table) {
            $table->string('nic')->nullable()->change();
        });

        // Make full_name nullable too (progressive signup sets it to email temporarily)
        Schema::table('trainee_users', function (Blueprint $table) {
            $table->string('full_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('trainee_users', function (Blueprint $table) {
            $table->string('nic')->nullable(false)->change();
            $table->string('full_name')->nullable(false)->change();
        });
    }
};
