<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = ['booking_id', 'member_reason', 'member_proof_photo_path', 'trainer_reply', 'status'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
