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
        Schema::create('trainer_ratings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trainee_id')
            ->constrained('trainees')
            ->onDelete('cascade');

            $table->foreignId('trainer_id')
            ->constrained('trainers')
            ->onDelete('cascade');

            $table->text('comment')->nullable();

            $table->tinyInteger('clarity');

            $table->tinyInteger('interaction');

            $table->tinyInteger('organization');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_ratings');
    }
};
