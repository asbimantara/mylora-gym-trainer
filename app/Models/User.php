<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isTrainer(): bool { return $this->role === 'trainer'; }
    public function isMember(): bool { return $this->role === 'member'; }

    public function trainerProfile()
    {
        return $this->hasOne(TrainerProfile::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function packagePurchases()
    {
        return $this->hasMany(PackagePurchase::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
