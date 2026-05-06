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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('nama_pelanggan');
        $table->decimal('total_harga', 12, 2);
        $table->decimal('dp', 12, 2);
        
        // 4 Status yang Anda inginkan
        $table->enum('status', ['pending_dp', 'pending', 'done', 'canceled'])->default('pending_dp');
        
        $table->timestamps();
    });
}
};
