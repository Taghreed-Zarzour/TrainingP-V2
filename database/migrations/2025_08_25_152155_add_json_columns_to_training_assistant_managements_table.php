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
            // إضافة أعمدة جديدة لتخزين المصفوفات
            $table->json('trainer_ids')->nullable()->after('trainer_id');
            $table->json('assistant_ids')->nullable()->after('assistant_id');
            
            // جعل الأعمدة القديمة nullable
            $table->unsignedBigInteger('trainer_id')->nullable()->change();
            $table->unsignedBigInteger('assistant_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_assistant_managements', function (Blueprint $table) {
            $table->dropColumn(['trainer_ids', 'assistant_ids']);
        });
    }
};