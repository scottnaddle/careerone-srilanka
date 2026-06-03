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
        Schema::create('school_kids', function (Blueprint $table) {
            $table->id();
            $table->string('username',100)->nullable();
            $table->string('password');
            $table->string('first_name',60)->nullable();
            $table->string('last_name',60)->nullable();
            $table->string('gender',2)->nullable();
            $table->text('permanant_address')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('district_id',3)->nullable();
            $table->string('profile_image')->nullable();
            $table->string('email',150)->unique();
            $table->string('telephone',20)->nullable();
            $table->string('mobile',20)->nullable();
            $table->tinyInteger('public_portfolio')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('recommended_by_user_id')->nullable();
            $table->string('recommended_by_user_system')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schoolkids');
    }
};
