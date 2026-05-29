<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainee_users', function (Blueprint $table) {
            $table->boolean('profile_incomplete')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('trainee_users', function (Blueprint $table) {
            $table->dropColumn('profile_incomplete');
        });
    }
};
