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
        'phone', 
        'password',
        'role', 
        'otp_code', 
        'otp_expires_at', 
        'is_verified',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token', 'otp_code'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'is_verified'       => 'boolean',
        'is_active'         => 'boolean', 
    ];

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }

    public function generateOtp(): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update(['otp_code' => $otp, 'otp_expires_at' => now()->addMinutes(10)]);
        return $otp;
    }

    public function verifyOtp(string $otp): bool
    {
        return $this->otp_code === $otp
            && $this->otp_expires_at
            && now()->lessThanOrEqualTo($this->otp_expires_at);
    }

    public function clearOtp(): void
    {
        $this->update(['otp_code' => null, 'otp_expires_at' => null]);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(\App\Models\Wishlist::class);
    }
}
