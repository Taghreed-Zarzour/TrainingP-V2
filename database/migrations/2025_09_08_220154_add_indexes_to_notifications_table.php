<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // في ملف database/migrations/xxxx_xx_xx_xxxxxx_add_indexes_to_notifications_table.php
public function up()
{
    Schema::table('notifications', function (Blueprint $table) {
        $table->index(['notifiable_id', 'notifiable_type']);
        $table->index('created_at');
        $table->index('read_at');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainees', function (Blueprint $table) {
            
        });
    }
};
