<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->unique();

            $table->foreignId('organization_type_id')
            ->references('id')
            ->on('organization_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('website');

            $table->foreignId('employee_numbers_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->year('established_year');

            $table->foreignId('annual_budgets_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->json('branches')->nullable();

            $table->json('organization_sectors');


            $table->foreign('id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};