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
        Schema::table('org_training_details', function (Blueprint $table) {
            $table->dropColumn('session_date');

            $table->dropColumn('session_start_time');

            $table->dropColumn('session_end_time');

            $table->dropColumn('schedule_later');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_training_details', function (Blueprint $table) {
            //
        });
    }
};
