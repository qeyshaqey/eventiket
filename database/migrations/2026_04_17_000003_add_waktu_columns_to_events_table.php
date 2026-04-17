<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->time('waktu_mulai')->nullable()->after('tanggal_selesai');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
        });
    }
};