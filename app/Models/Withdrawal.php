<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['trainer_profile_id', 'amount', 'bank_name', 'account_number', 'account_name', 'status'];

    public function trainerProfile()
    {
        return $this->belongsTo(TrainerProfile::class);
    }
}
