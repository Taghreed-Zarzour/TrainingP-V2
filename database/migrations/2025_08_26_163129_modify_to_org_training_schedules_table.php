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
            $table->dropForeign(['org_training_detail_id']);
            $table->dropColumn('org_training_detail_id');

            $table->foreignId('org_training_program_id')
            ->references('id')
            ->on('org_training_programs')
            ->onDelete('cascade')
            ;
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
