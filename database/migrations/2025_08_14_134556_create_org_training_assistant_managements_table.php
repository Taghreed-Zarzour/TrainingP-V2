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
        Schema::create('org_assistant_managements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_training_program_id')
            ->references('id')
            ->on('org_training_programs')
            ->onDelete('cascade');


            $table->foreignId('assistant_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_training_assistant_managements');
    }
};
