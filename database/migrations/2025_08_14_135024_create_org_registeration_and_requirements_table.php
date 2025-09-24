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
        Schema::create('org_registeration_requirements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_training_program_id')
            ->references('id')
            ->on('org_training_programs')
            ->onDelete('cascade');


            $table->decimal('cost', 10, 2)->nullable();

            $table->boolean('is_free')->default(false);

            $table->string('currency', 10)->nullable();

            $table->string('payment_method')->nullable(); 

            $table->date('application_deadline');

            $table->unsignedInteger('max_trainees');

            $table->enum('application_submission_method', ['inside_platform', 'outside_platform']);

            $table->string('registration_link')->nullable();

            $table->longText('requirements');         

            $table->longText('benefits');

            $table->string('training_image')->nullable();  
            
            $table->text('welcome_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_registeration_and_requirements');
    }
};
