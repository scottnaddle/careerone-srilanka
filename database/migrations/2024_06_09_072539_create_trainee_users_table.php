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
        Schema::create('trainee_users', function (Blueprint $table) {
            $table->id();
            $table->string('nic',12)->unique();
            $table->string('username',100)->nullable();
            $table->string('password');
            $table->string('full_name');
            $table->string('first_name',60)->nullable();
            $table->string('last_name',60)->nullable();
            $table->string('gender',2)->nullable();
            $table->text('permanant_address')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('email',150)->unique();
            $table->string('telephone',20)->nullable();
            $table->string('mobile',20)->nullable();
            $table->tinyInteger('open_to_work')->default(0);
            $table->tinyInteger('public_portfolio')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('std_surname')->nullable();
            $table->string('std_initials',60)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_users');
    }
};
