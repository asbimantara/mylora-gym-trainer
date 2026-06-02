<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_profile_id',
        'package_purchase_id',
        'session_date',
        'start_time',
        'end_time',
        'status',
        'payout_status',
        'proof_photo_path',
        'attendance_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainerProfile()
    {
        return $this->belongsTo(TrainerProfile::class);
    }

    public function packagePurchase()
    {
        return $this->belongsTo(PackagePurchase::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function dispute()
    {
        return $this->hasOne(Dispute::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'waiting_confirmation' => 'warning text-dark',
            'completed' => 'success',
            'cancelled' => 'danger',
            'disputed' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'waiting_confirmation' => 'Menunggu ACC Member',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'disputed' => 'Komplain (Dispute)',
            default => $this->status,
        };
    }
}
