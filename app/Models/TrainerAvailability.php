<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_profile_id',
        'day_of_week',
        'start_hour',
        'end_hour',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function trainerProfile()
    {
        return $this->belongsTo(TrainerProfile::class);
    }

    public function getDayNameAttribute(): string
    {
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return $days[$this->day_of_week] ?? '';
    }
}
