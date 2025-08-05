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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId(column: 'trainee_id')
            ->references('id')
            ->on('trainees')
            ->onDelete('cascade');

            $table->foreignId(column: 'training_programs_id')
            ->references('id')
            ->on('training_programs')
            ->onDelete('cascade');

            $table->enum('status',['pending','accepted','rejected'])->default('pending');

            $table->timestamp('registered_at');

            $table->string('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eenrollments');
    }
};
