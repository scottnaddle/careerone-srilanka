<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['trainee_users', 'company_recruiters', 'cgo_users'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('magic_link_token', 64)->nullable()->unique();
                $table->timestamp('magic_link_expires_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['trainee_users', 'company_recruiters', 'cgo_users'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['magic_link_token', 'magic_link_expires_at']);
            });
        }
    }
};
