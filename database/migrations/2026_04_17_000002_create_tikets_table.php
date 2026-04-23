<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('tikets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->onDelete('cascade');

        $table->string('nama');
        $table->integer('harga');
        $table->integer('kuota');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};