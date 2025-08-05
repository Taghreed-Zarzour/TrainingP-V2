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
        Schema::create('training_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_program_id')
            ->references('id')
            ->on('training_programs')
            ->onDelete('cascade');
            
            $table->longText('learning_outcomes');   
            $table->longText('requirements');         
            $table->longText('target_audience');      
            $table->longText('benefits');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_details');
    }
};
