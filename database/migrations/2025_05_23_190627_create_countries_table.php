<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->string('iso2', 2)->charset('utf8')->nullable();
            $table->string('Languages', 92)->charset('utf8')->nullable();
            $table->string('Name_EN', 44)->charset('utf8')->nullable();
            $table->string('Name_FA', 35)->charset('utf8')->nullable();
            $table->string('name', 38)->charset('utf8')->nullable();
            $table->string('phonecode', 16)->charset('utf8')->nullable();
            $table->decimal('Latitude', 7, 5)->nullable();
            $table->decimal('Longitude', 8, 5)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
