<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            if (!Schema::hasColumn('tikets', 'keterangan')) {
                $table->text('keterangan')->after('kuota');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            if (Schema::hasColumn('tikets', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
