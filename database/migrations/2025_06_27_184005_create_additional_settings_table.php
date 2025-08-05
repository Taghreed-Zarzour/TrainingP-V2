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
        Schema::create('additional_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_program_id')->constrained()->onDelete('cascade');

            $table->decimal('cost', 10, 2)->nullable();
            $table->boolean('is_free')->default(false);
            $table->string('currency', 10)->nullable();
            $table->string('payment_method')->nullable(); 

            $table->foreignId('country_id')->nullable()->constrained()->onDelete('set null');
            $table->string('city')->nullable();
            $table->text('residential_address')->nullable();

            $table->date('application_deadline');
            $table->unsignedInteger('max_trainees');

            $table->enum('application_submission_method', ['inside_platform', 'outside_platform']);
            $table->string('registration_link')->nullable();

            $table->string('profile_image')->nullable();       
            $table->json('training_files')->nullable(); 
             $table->text('welcome_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_settings');
    }
};
