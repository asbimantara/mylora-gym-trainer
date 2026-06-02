<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'bio',
        'specialization',
        'experience_years',
        'price_per_session',
        'session_duration',
        'location',
        'gym_name',
        'certifications',
        'phone',
        'photo',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'price_per_session' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function packages()
    {
        return $this->hasMany(TrainerPackage::class);
    }

    public function activePackages()
    {
        return $this->hasMany(TrainerPackage::class)->where('is_active', true);
    }

    public function availabilities()
    {
        return $this->hasMany(TrainerAvailability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function packagePurchases()
    {
        return $this->hasMany(PackagePurchase::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    public function getSessionDurationHoursAttribute(): string
    {
        $duration = $this->session_duration ?? 60;
        if ($duration >= 60) {
            $hours = floor($duration / 60);
            $mins = $duration % 60;
            return $mins > 0 ? "{$hours} jam {$mins} menit" : "{$hours} jam";
        }
        return "{$duration} menit";
    }
}
