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
        Schema::create('cgo_counselings', function (Blueprint $table) {
            $table->id();
            $table->string('counseling_type', 6);
            $table->bigInteger('counseling_field_id');
            $table->string('title');
            $table->timestamp('registration_date');
            $table->text('location')->nullable();
            $table->bigInteger('institute_id')->nullable();
            $table->text('detail_information');
            $table->timestamp('available_time');
            $table->enum('shift', ['AM', 'PM'])->nullable();
            $table->bigInteger('trainee_id')->nullable();
            $table->string('trainee_nic', 12);
            $table->tinyInteger('status');
            $table->text('result')->nullable();
            $table->tinyInteger('feedback')->nullable();
            $table->addColumn('jsonb', 'feedback_message')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('trainee_offline_firstname')->nullable();
            $table->string('trainee_offline_lastname')->nullable();
            $table->string('trainee_offline_mobile')->nullable();
            $table->text('trainee_offline_institute')->nullable();
            $table->string('trainee_offline_email', 40)->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('counseling_field_id')->references('id')->on('counseling_fields')->onDelete('cascade');
            $table->foreign('trainee_id')->references('id')->on('trainee_users')->onDelete('cascade');
            $table->foreign('institute_id')->references('id')->on('institutes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cgo_counselings');
    }
};
