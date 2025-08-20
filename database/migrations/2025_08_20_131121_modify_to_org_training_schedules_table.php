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
        Schema::table('org_training_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('num_of_session')->nullable()->default(null)->change();

            $table->unsignedBigInteger('num_of_hours')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_training_schedules', function (Blueprint $table) {
            //
        });
    }
};
