<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'tanggal_booking',
        'jam_booking',
        'jumlah_orang',
        'nomor_meja',
        'menu',
        'catatan',
    ];

    protected $casts = [
        'menu' => 'array',
    ];
}