<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_nationalities', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('country_id');

            // مفاتيح أجنبية لضمان التكامل المرجعي
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            // لمنع التكرار
            $table->primary(['user_id', 'country_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_nationalities');
    }
};
