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
        Schema::table('training_assistant_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('trainer_id')->nullable()->change();
            $table->unsignedBigInteger('assistant_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_assistant_managements_tabl', function (Blueprint $table) {
            //
        });
    }
};
