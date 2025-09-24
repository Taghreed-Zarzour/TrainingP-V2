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
        Schema::table('org_training_goals', function (Blueprint $table) {

            $table->longText('learning_outcomes')->nullable()->change();   
        
            $table->longText('target_audience')->nullable()->change();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_training_goals', function (Blueprint $table) {
            //
        });
    }
};
