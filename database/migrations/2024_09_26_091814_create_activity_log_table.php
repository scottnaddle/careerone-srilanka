<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    public function up()
{
    // Create the activity log table using the specified database connection and table name
    Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
        $table->bigIncrements('id'); // Auto-incrementing ID
        $table->string('log_name')->nullable(); // Nullable log name
        $table->text('description'); // Description of the log
        $table->string('subject_type')->nullable();
        $table->ulid('subject_id')->nullable();
        $table->string('causer_type')->nullable(); 
        $table->ulid('causer_id')->nullable(); // Causer ID // Polymorphic causer column with ulid
        $table->json('properties')->nullable(); // Nullable JSON properties column
        $table->timestamps(); // Created at and updated at timestamps
        $table->index('log_name'); // Index on log name for better performance
    });
}

public function down()
{
    // Drop the activity log table if it exists
    Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
}
    
}
