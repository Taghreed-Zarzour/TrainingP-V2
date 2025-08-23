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

          $table->boolean('schedule_later')->default(false)->after('trainer_id');

          $table->unsignedBigInteger('num_of_session')->nullable()->default(null)->after('schedule_later');;

          $table->unsignedBigInteger('num_of_hours')->nullable()->default(null)->after('num_of_session');;
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
