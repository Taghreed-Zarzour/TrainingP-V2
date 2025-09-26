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
        Schema::table('org_training_details', function (Blueprint $table) {
            $table->longText('program_description')->nullable();

            $table->longText('learning_outcomes')->nullable();;

            $table->string('program_type')->nullable();

            $table->foreignId('language_id')
            ->nullable()
            ->references('id')
            ->on('languages')
            ->onDelete('cascade');

            $table->json('classification')->nullable();

            $table->string('program_presentation_method')->nullable();

            $table->string('image')->nullable();

            $table->foreignId('assistant_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_training_details', function (Blueprint $table) {
            //
        });
    }
};
