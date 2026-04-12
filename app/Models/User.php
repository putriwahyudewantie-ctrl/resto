<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Otomatis jadikan Admin jika namanya ada di daftar "Bintang" (Case-Insensitive)
     */
    public function getRoleAttribute($value)
    {
        $adminNames = ['hanna', 'dwiky', 'farel', 'dawai', 'destri', 'dew'];
        $nameLower = strtolower($this->name);
        
        // Cek Admin
        if (in_array($nameLower, $adminNames)) {
            return 'admin';
        }

        // Otomatis jadikan Dapur jika ada unsur kata "dapur" di namanya (contoh: dew dapur)
        if (strpos($nameLower, 'dapur') !== false) {
            return 'dapur';
        }

        // Kalau diatur dari panel admin (database)
        if (in_array($value, ['admin', 'dapur', 'customer'])) {
            return $value;
        }

        return 'customer';
    }
}