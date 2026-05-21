<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->timestamps();
        });

        // Seed default categories
        $defaultCategories = [
            ['nama_kategori' => 'Musik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sosial', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Festival', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Hiburan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Seminar', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Keagamaan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Pameran', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Workshop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Talkshow', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategoris')->insert($defaultCategories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
