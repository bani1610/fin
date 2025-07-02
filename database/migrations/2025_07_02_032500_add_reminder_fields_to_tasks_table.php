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
        Schema::table('tasks', function (Blueprint $table) {
            // Tambahkan kolom untuk menandai notifikasi yang sudah terkirim
            $table->timestamp('one_day_reminder_sent_at')->nullable()->after('status');
            $table->timestamp('three_hour_reminder_sent_at')->nullable()->after('one_day_reminder_sent_at');
        });
    }

    // Jangan lupa tambahkan method down() untuk rollback
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['one_day_reminder_sent_at', 'three_hour_reminder_sent_at']);
        });
    }
};
