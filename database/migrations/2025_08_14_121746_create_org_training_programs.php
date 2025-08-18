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
        Schema::create('org_training_programs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->longText('title');

            $table->foreignId('language_id')
            ->references('id')
            ->on('languages')
            ->onDelete('cascade');

            $table->foreignId('country_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');


            $table->string('city')->nullable();

            $table->longText('address_in_detail')->nullable();

            $table->string('program_type')->nullable();

            $table->foreignId('training_level_id')
            ->nullable()
            ->constrained('training_levels')
            ->onDelete('cascade');

            $table->string('program_presentation_method')->nullable();

            $table->json('org_training_classification_id')->nullable();

            $table->longText('program_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_training_programs');
    }
};
