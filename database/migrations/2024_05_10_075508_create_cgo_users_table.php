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
        Schema::create('cgo_users', function (Blueprint $table) {
            $table->id();
            $table->string('nic',12)->nullable();
            $table->string('first_name',60);
            $table->string('last_name',60);
            $table->string('email',150)->unique();
            $table->string('password');
            $table->string('telephone',20);
            $table->string('profile_image')->nullable();
            $table->string('district_id',3);
            $table->bigInteger('institute_id');
            $table->timestamp('verify_at')->nullable();
            $table->unsignedInteger('verify_by')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('attached_file');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cgo_users');
    }
};
