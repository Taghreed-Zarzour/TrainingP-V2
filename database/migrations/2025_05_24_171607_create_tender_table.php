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
        Schema::create('tender', function (Blueprint $table) {
            $table->id();

            $table->text('bio');

            $table->string('entity_type')->nullable();

            $table->string('execution_method');

            $table->string('training_level');

            $table->foreignId('language_id')
            ->references('id')
            ->on('languages')
            ->onDelete('cascade');

            $table->string('trainees_type');

            $table->string('tender_duration');

            $table->foreignId('country_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');


            $table->string('city')->nullable();


            $table->longText('required_service');

            $table->text('training_requirements');

            $table->text('payment_terms');

            $table->text('evaluation_method');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender');
    }
};
