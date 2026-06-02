<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_package_id',
        'trainer_profile_id',
        'sessions_total',
        'sessions_used',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainerPackage()
    {
        return $this->belongsTo(TrainerPackage::class);
    }

    public function trainerProfile()
    {
        return $this->belongsTo(TrainerProfile::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getSessionsRemainingAttribute(): int
    {
        return $this->sessions_total - $this->sessions_used;
    }

    public function getProgressPercentAttribute(): int
    {
        return $this->sessions_total > 0 ? round(($this->sessions_used / $this->sessions_total) * 100) : 0;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'active' => 'success',
            'completed' => 'info',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }
}
