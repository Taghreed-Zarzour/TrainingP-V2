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
            // إضافة حقول عدد الساعات والجلسات بعد حقل schedules_later
            $table->integer('num_of_session')->nullable()->after('schedules_later');
            $table->decimal('num_of_hours', 5, 1)->nullable()->after('num_of_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_programs', function (Blueprint $table) {
            // حذف الحقول في حالة التراجع عن الترحيل
            $table->dropColumn(['num_of_session', 'num_of_hours']);
        });
    }
};