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
        Schema::table('training_details', function (Blueprint $table) {
            $table->dropColumn('target_audience');
            $table->json('education_level_id')->nullable();
            $table->json('work_status')->nullable(); 
            $table->json('work_sector_id')->nullable();
            $table->json('job_position')->nullable();
            $table->json('country_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_details', function (Blueprint $table) {
            //
        });
    }
};
