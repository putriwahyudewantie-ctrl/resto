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
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->integer('jumlah_orang');
            $table->integer('nomor_meja');
            $table->text('menu');
            $table->text('catatan')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};