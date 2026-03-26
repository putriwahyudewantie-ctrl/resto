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
        
        if (in_array(strtolower($this->name), $adminNames)) {
            return 'admin';
        }

        return $value ?: 'customer';
    }
}