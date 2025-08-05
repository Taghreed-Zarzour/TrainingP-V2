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
        Schema::table('training_programs', function (Blueprint $table) {
            // إضافة علاقات المفتاح الأجنبي
            $table->foreignId('program_type_id')
                  ->nullable()
                  ->constrained('program_types')
                  ->onDelete('cascade');
                  
            $table->foreignId('language_type_id')
                  ->nullable()
                  ->constrained('languages')
                  ->onDelete('cascade');
                  
            $table->foreignId('training_classification_id')
                  ->nullable()
                  ->constrained('training_classifications')
                  ->onDelete('cascade');
                  
            $table->foreignId('training_level_id')
                  ->nullable()
                  ->constrained('training_levels')
                  ->onDelete('cascade');
            
            // إضافة حقل طريقة التقديم
            $table->string('program_presentation_method_id')->nullable();
            
            // إضافة حقل تحديد الجلسات لاحقاً
            $table->boolean('schedules_later')->default(false)->after('program_presentation_method_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_programs', function (Blueprint $table) {
            // حذف جميع الأعمدة التي تمت إضافتها
            $table->dropColumn([
                'program_type_id',
                'language_type_id', 
                'training_classification_id',
                'training_level_id',
                'program_presentation_method_id',
                'schedules_later'
            ]);
        });
    }
};