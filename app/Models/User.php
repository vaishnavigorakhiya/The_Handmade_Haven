<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // /** @use HasFactory<UserFactory> */
    // use HasFactory, Notifiable;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var list<string>
    //  */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var list<string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }


        use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password',
        'role', 'otp_code', 'otp_expires_at', 'is_verified',
    ];

    protected $hidden = ['password', 'remember_token', 'otp_code'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'is_verified'       => 'boolean',
    ];

    // ── Role helpers ──
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // ── OTP helpers ──
    public function generateOtp(): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);
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

    // ── Orders relationship ──
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
