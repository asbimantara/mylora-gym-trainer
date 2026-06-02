<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_profile_id',
        'name',
        'session_count',
        'price',
        'description',
        'benefits',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function trainerProfile()
    {
        return $this->belongsTo(TrainerProfile::class);
    }

    public function purchases()
    {
        return $this->hasMany(PackagePurchase::class);
    }

    public function getPricePerSessionAttribute(): float
    {
        return $this->session_count > 0 ? $this->price / $this->session_count : 0;
    }

    public function getDiscountPercentAttribute(): int
    {
        // Compare with single session package from same trainer
        $single = self::where('trainer_profile_id', $this->trainer_profile_id)
            ->where('session_count', 1)
            ->first();

        if (!$single || $this->session_count <= 1) return 0;

        $singleTotal = $single->price * $this->session_count;
        return $singleTotal > 0 ? round((1 - $this->price / $singleTotal) * 100) : 0;
    }

    public function getBenefitsArrayAttribute(): array
    {
        if (!$this->benefits) return [];
        return array_map('trim', explode(',', $this->benefits));
    }
}
