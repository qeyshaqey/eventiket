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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('order_id')->unique()->after('id')->nullable();
            $table->string('snap_token')->nullable()->after('status');
            $table->string('status')->default('pending')->change(); // Mengubah dari enum ke string agar lebih fleksibel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'snap_token']);
        });
    }
};
