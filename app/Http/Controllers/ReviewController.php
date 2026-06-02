<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->findOrFail($bookingId);

        // Check if already reviewed
        if ($booking->review) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk booking ini.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'trainer_profile_id' => $booking->trainer_profile_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan kamu berhasil disimpan.');
    }
}
