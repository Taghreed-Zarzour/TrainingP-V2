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
        Schema::table('org_training_goals', function (Blueprint $table) {
            $table->dropColumn('target_audience');
            
            $table->foreignId('education_level_id')
            ->nullable()
            ->references('id')
            ->on('education_levels')
            ->onDelete('cascade');

            $table->boolean('work_status')
            ->nullable();

            $table->foreignId('work_sector_id')
            ->nullable()
            ->references('id')
            ->on('work_sectors')
            ->onDelete('cascade');

            $table->string('job_position')
            ->nullable()
            ->after('work_sector_id');

            $table->foreignId('country_id')
            ->nullable()
            ->references('id')
            ->on('countries')
            ->onDelete('cascade');



            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_training_goals', function (Blueprint $table) {
            //
        });
    }
};
