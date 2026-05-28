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
        Schema::table('pengajuan_panitias', function (Blueprint $table) {
            $table->string('nama_event')->nullable();
            $table->string('kategori')->nullable();
            $table->date('tanggal_event')->nullable();
            $table->text('deskripsi_event')->nullable();
            $table->text('alasan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_panitias', function (Blueprint $table) {
            $table->dropColumn(['nama_event', 'kategori', 'tanggal_event', 'deskripsi_event']);
            $table->text('alasan')->nullable(false)->change();
        });
    }
};
