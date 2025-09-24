<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // تعديل جدول training_programs
        Schema::table('training_programs', function (Blueprint $table) {
            // نحول العمود من enum إلى string مع الحفاظ على القيمة الحالية
            $table->string('status', 50)->default('offline')->change();
        });

        // تعديل جدول org_training_programs
        Schema::table('org_training_programs', function (Blueprint $table) {
            $table->string('status', 50)->default('offline')->change();
        });
    }

    public function down(): void
    {
        // لو حبيت ترجعها كما كانت (enum)
        Schema::table('training_programs', function (Blueprint $table) {
            $table->enum('status', ['online','offline'])->default('offline')->change();
        });

        Schema::table('org_training_programs', function (Blueprint $table) {
            $table->enum('status', ['online','offline'])->default('offline')->change();
        });
    }
};
