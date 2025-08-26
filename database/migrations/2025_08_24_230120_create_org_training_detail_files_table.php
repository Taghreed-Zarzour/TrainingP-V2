<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**َ
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('org_training_detail_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_training_program_id')
            ->references('id')
            ->on('org_training_programs')
            ->onDelete('cascade');

            $table->json('training_files')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_training_detail_files');
    }
};
