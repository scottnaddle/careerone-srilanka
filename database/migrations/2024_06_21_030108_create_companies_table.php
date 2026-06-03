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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('logo')->nullable();
            $table->string('email',150)->nullable();
            $table->string('hotline')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('date_of_establishment')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('number_workers')->default(0);
            $table->string('website')->nullable();
            $table->json('attachment_details')->nullable();
            $table->string('office_type',2)->nullable();
            $table->string('name_of_representation')->nullable();
            $table->text('co_business')->nullable();
            $table->integer('enterprise_id')->nullable();
            $table->string('district_id',3);
            $table->integer('ds_id')->nullable();
            $table->string('slug')->nullable();
            $table->text('services')->nullable();
            $table->text('short_bio')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->integer('verified_by')->nullable();
            $table->integer('headquarter_id')->nullable();
            $table->integer('company_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
