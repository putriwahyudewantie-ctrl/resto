<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->integer('jumlah_orang');
            $table->integer('nomor_meja');
            $table->json('menu')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('Pending');
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->integer('dp')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
