<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('kategori');
        $table->text('deskripsi')->nullable();

        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai')->nullable();

        $table->time('waktu_mulai');
        $table->time('waktu_selesai')->nullable();

        $table->string('lokasi')->nullable();
        $table->string('poster')->nullable();

        $table->enum('status', ['Draft', 'Published', 'Rejected'])
              ->default('Draft');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};