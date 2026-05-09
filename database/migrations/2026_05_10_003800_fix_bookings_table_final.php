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
        Schema::table('bookings', function (Blueprint $table) {
            // Add kode_pembayaran if it doesn't exist
            if (!Schema::hasColumn('bookings', 'kode_pembayaran')) {
                $table->string('kode_pembayaran')->nullable()->after('dp');
            }

            // Change status to string to allow any status name used in the app
            $table->string('status')->default('Pending DP')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('kode_pembayaran');
            $table->enum('status', ['pending_dp', 'pending', 'done', 'canceled'])->change();
        });
    }
};
