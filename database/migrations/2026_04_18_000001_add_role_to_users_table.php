<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'panitia', 'pengunjung'])->default('pengunjung')->after('email');
            $table->string('no_telepon')->nullable()->after('role');
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending')->after('no_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_telepon', 'status']);
        });
    }
};