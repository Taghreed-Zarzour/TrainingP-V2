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
        Schema::create('session_attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('session_id')
            ->constrained('scheduling_training_sessions')
            ->onDelete('cascade');

            $table->foreignId('trainee_id')
            ->constrained('trainees')
            ->onDelete('cascade');

            $table->boolean('attended')->default(false);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_attendance');
    }
};
