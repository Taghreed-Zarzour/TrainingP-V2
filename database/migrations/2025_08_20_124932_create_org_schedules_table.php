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
        Schema::create('org_training_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_training_detail_id')
            ->references('id')
            ->on('org_training_details')
            ->onDelete('cascade');

            $table->date('session_date')->nullable();

            $table->time('session_start_time')->nullable();

            $table->time('session_end_time')->nullable();

            $table->boolean('schedule_later')->default(false);

            $table->unsignedBigInteger('num_of_session')->nullable()->default(0);

            $table->unsignedBigInteger('num_of_hours')->nullable()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_schedules');
    }
};
