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
            $table->renameColumn('organisasi', 'nama_organisasi');
            $table->renameColumn('deskripsi_event', 'deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_panitias', function (Blueprint $table) {
            $table->renameColumn('nama_organisasi', 'organisasi');
            $table->renameColumn('deskripsi', 'deskripsi_event');
        });
    }
};
