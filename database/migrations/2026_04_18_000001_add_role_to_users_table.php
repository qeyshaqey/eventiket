<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // nambahin kolom role sama no_telepon ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'panitia', 'pengunjung'])->default('pengunjung')->after('email');
            $table->string('no_telepon')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        // hapus kolom role dan no_telepon kalau migration di-rollback
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_telepon']);
        });
    }
};