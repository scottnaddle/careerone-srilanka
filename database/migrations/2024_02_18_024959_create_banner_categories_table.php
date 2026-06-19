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
        Schema::create('banner_categories', function (Blueprint $table) {
            // Use ULID as primary key
            $table->ulid('id')->primary();
            $table->ulid('parent_id')->nullable(); // Foreign key to parent category
            $table->string('name'); // Category name
            $table->string('slug')->unique(); // Category slug
            $table->longText('description')->nullable(); // Category description
            $table->boolean('is_active')->default(false); // Active status
            $table->timestamps(); // Created and updated timestamps
        });

        // Add foreign key constraint for the parent_id field
        Schema::table('banner_categories', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('banner_categories')
                ->onDelete('cascade'); // Cascade delete if parent is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_categories', function (Blueprint $table) {
            // Drop the foreign key constraint before dropping the table
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('banner_categories'); // Drop the table if it exists
    }
};
