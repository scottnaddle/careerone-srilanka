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
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('nic',12)->nullable();
            $table->string('first_name',60)->nullable(false);
            $table->string('last_name',60)->nullable(false);
            $table->string('username',100)->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('phone',20)->nullable(false);
            $table->string('email',150)->nullable(false);
            $table->string('role')->nullable();
            $table->string('tvet_type')->nullable();
            $table->timestamp('verify_at')->nullable();
            $table->integer('verify_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
