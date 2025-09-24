<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();

            $table->string('last_name')->nullable();

            $table->string('sex');

            $table->json('nationality');

            $table->json('work_fields');

            $table->string('extra_work_field')->nullable();

            $table->foreignId('education_levels_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->json('fields_of_interest');

            $table->boolean('is_working');

            $table->string('job_position')->nullable();

            $table->json('work_sectors')->nullable();

            $table->json('preferred_times')->nullable();

            $table->String('training_attendance');

            $table->string('work_institution')->nullable();

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
