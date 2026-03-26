<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    // Menentukan nama tabel secara manual karena nama tabelmu 'meja' (bukan 'mejas')
    protected $table = 'meja';

    // Kolom yang boleh diisi secara massal
    protected $fillable = ['no_meja', 'kapasitas', 'status'];
}