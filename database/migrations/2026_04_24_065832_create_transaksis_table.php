<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); // nama pembeli
        $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        $table->integer('total');
        $table->string('status')->default('pending'); // pending / sukses
        $table->timestamps();
    });
}
};
