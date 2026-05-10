<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'no_hp',
        'tanggal_booking',
        'jam_booking',
        'jumlah_orang',
        'nomor_meja',
        'menu',
        'catatan',
        'status',
        'total_harga',
        'dp',
        'kode_pembayaran',
    ];

    protected $casts = [
        'menu' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}