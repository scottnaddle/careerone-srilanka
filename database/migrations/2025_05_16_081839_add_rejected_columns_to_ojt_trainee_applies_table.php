<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ojt_trainee_applies', function (Blueprint $table) {
            $table->timestamp('rejected_at')->nullable()->after('apply_type');
        });
    }

    public function down()
    {
        Schema::table('ojt_trainee_applies', function (Blueprint $table) {
            $table->dropColumn(['rejected_at']);
        });
    }

};
