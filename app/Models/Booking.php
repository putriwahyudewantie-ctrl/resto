<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
'nama_pelanggan',
'no_hp',
'tanggal_booking',
'jam_booking',
'jumlah_orang',
'nomor_meja',
'menu',
'catatan'
];
}