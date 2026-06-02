<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TrainerProfile;
use App\Models\TrainerPackage;
use App\Models\PackagePurchase;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Step 1: Choose package
    public function selectPackage($trainerId)
    {
        $profile = TrainerProfile::with(['user', 'category', 'packages' => fn($q) => $q->where('is_active', true)->orderBy('session_count')])
            ->where('is_approved', true)->findOrFail($trainerId);

        return view('bookings.select-package', compact('profile'));
    }

    // Step 2: Checkout & Pay for package
    public function checkout(Request $request, $trainerId)
    {
        $request->validate(['package_id' => 'required|exists:trainer_packages,id']);

        $profile = TrainerProfile::with('user')->where('is_approved', true)->findOrFail($trainerId);
        $package = TrainerPackage::where('trainer_profile_id', $profile->id)->findOrFail($request->package_id);

        // Create purchase
        $purchase = PackagePurchase::create([
            'user_id' => auth()->id(),
            'trainer_package_id' => $package->id,
            'trainer_profile_id' => $profile->id,
            'sessions_total' => $package->session_count,
            'sessions_used' => 0,
            'status' => 'pending',
        ]);

        // Create transaction
        $amount = $package->price;
        $platformFee = $amount * 0.1;

        // Midtrans Configuration
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        
        // Disable SSL Verification locally to prevent "unable to get local issuer certificate" error
        if (!\Midtrans\Config::$isProduction) {
            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => [],
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'MYLORA-' . $purchase->id . '-' . time(),
                'gross_amount' => $amount + $platformFee,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
            ],
            'item_details' => [
                [
                    'id' => 'PKG-'.$package->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Paket: ' . $package->name,
                ],
                [
                    'id' => 'FEE-PLATFORM',
                    'price' => $platformFee,
                    'quantity' => 1,
                    'name' => 'Biaya Platform (10%)',
                ]
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Update transaction with new order id just in case
            Transaction::create([
                'package_purchase_id' => $purchase->id,
                'user_id' => auth()->id(),
                'amount' => $amount,
                'platform_fee' => $platformFee,
                'status' => 'pending',
                'midtrans_order_id' => $params['transaction_details']['order_id'],
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            $snapToken = null; // Fallback if API fails
            
            Transaction::create([
                'package_purchase_id' => $purchase->id,
                'user_id' => auth()->id(),
                'amount' => $amount,
                'platform_fee' => $platformFee,
                'status' => 'pending',
                'midtrans_order_id' => $params['transaction_details']['order_id'],
            ]);
        }

        return view('bookings.checkout', [
            'purchase' => $purchase->load(['trainerPackage', 'trainerProfile.user', 'trainerProfile.category', 'transaction']),
            'snapToken' => $snapToken,
        ]);
    }

    // Step 3: Process payment (Midtrans sandbox simulation)
    public function pay($purchaseId)
    {
        $purchase = PackagePurchase::with('transaction')
            ->where('user_id', auth()->id())->findOrFail($purchaseId);

        if (!$purchase->transaction) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $purchase->transaction->update([
            'status' => 'success',
            'payment_method' => 'Midtrans Sandbox',
            'midtrans_transaction_id' => 'SANDBOX-' . strtoupper(uniqid()),
            'paid_at' => now(),
        ]);
        
        $validityDays = $purchase->trainerPackage->validity_days ?? 30;
        $purchase->update([
            'status' => 'active',
            'expired_at' => now()->addDays($validityDays)
        ]);

        return redirect()->route('member.dashboard')
            ->with('success', 'Pembayaran berhasil! Kamu bisa mulai booking sesi latihan.');
    }

    // Step 4: Book individual session (from active package)
    public function bookSession($purchaseId)
    {
        $purchase = PackagePurchase::with(['trainerProfile.user', 'trainerProfile.availabilities', 'trainerPackage'])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->findOrFail($purchaseId);

        if ($purchase->sessions_remaining <= 0) {
            return redirect()->route('member.dashboard')->with('error', 'Semua sesi sudah digunakan.');
        }

        $profile = $purchase->trainerProfile;
        $availabilities = $profile->availabilities()->where('is_available', true)->orderBy('day_of_week')->get();

        return view('bookings.book-session', compact('purchase', 'profile', 'availabilities'));
    }

    // Step 5: Store individual session booking
    public function storeSession(Request $request, $purchaseId)
    {
        $request->validate([
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $purchase = PackagePurchase::with('trainerProfile')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->findOrFail($purchaseId);

        if ($purchase->sessions_remaining <= 0) {
            return back()->with('error', 'Semua sesi sudah digunakan.');
        }

        if ($purchase->expired_at && Carbon::parse($request->session_date)->startOfDay()->gt($purchase->expired_at)) {
            return back()->with('error', 'Tanggal sesi melewati masa aktif paket Anda (' . $purchase->expired_at->format('d M Y') . ').');
        }

        $profile = $purchase->trainerProfile;
        $sessionDate = Carbon::parse($request->session_date);
        $dayOfWeek = $sessionDate->dayOfWeek;
        $duration = $profile->session_duration ?? 60;

        // Check trainer available on that day
        $availability = $profile->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$availability) {
            return back()->with('error', 'Trainer tidak tersedia pada hari tersebut.');
        }

        $startTime = $request->start_time;
        $endTime = Carbon::parse($startTime)->addMinutes($duration)->format('H:i');

        // Check within working hours
        if ($startTime < $availability->start_hour || $endTime > $availability->end_hour) {
            return back()->with('error', 'Waktu yang dipilih di luar jam kerja trainer.');
        }

        // Check 12-hour cut-off
        $slotDateTime = Carbon::parse($request->session_date . ' ' . $startTime);
        if ($slotDateTime->lt(now()->addHours(12))) {
            return back()->with('error', 'Booking tidak bisa mendadak. Batas waktu minimal adalah 12 jam sebelum sesi.');
        }

        // Check time slot conflict
        $conflict = Booking::where('trainer_profile_id', $profile->id)
            ->whereDate('session_date', $request->session_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where(function ($q2) use ($startTime, $endTime) {
                    $q2->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Slot waktu tersebut sudah terbooking oleh member lain. Silakan pilih waktu lain.');
        }

        // Create booking
        Booking::create([
            'user_id' => auth()->id(),
            'trainer_profile_id' => $profile->id,
            'package_purchase_id' => $purchase->id,
            'session_date' => $request->session_date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'confirmed',
            'notes' => $request->notes,
        ]);

        // Increment sessions used
        $purchase->increment('sessions_used');

        // Auto-complete if all sessions used
        if ($purchase->sessions_used >= $purchase->sessions_total) {
            $purchase->update(['status' => 'completed']);
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Sesi berhasil dibooking! Sisa sesi: ' . ($purchase->sessions_remaining - 1));
    }

    // API: Get available time slots for a date
    public function getAvailableSlots(Request $request, $trainerId)
    {
        $request->validate(['date' => 'required|date']);

        $profile = TrainerProfile::findOrFail($trainerId);
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;
        $duration = $profile->session_duration ?? 60;

        $availability = $profile->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$availability) {
            return response()->json(['slots' => [], 'message' => 'Trainer tidak tersedia pada hari ini']);
        }

        // Generate all possible slots
        $slots = [];
        $start = Carbon::parse($availability->start_hour);
        $end = Carbon::parse($availability->end_hour);

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slotStart = $start->format('H:i');
            $slotEnd = $start->copy()->addMinutes($duration)->format('H:i');

            $isBooked = Booking::where('trainer_profile_id', $profile->id)
                ->whereDate('session_date', $request->date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($q) use ($slotStart, $slotEnd) {
                    $q->where('start_time', '<', $slotEnd)
                      ->where('end_time', '>', $slotStart);
                })->exists();

            // Check 12-hour cut-off
            $slotDateTime = Carbon::parse($request->date . ' ' . $slotStart);
            $isCutOff = $slotDateTime->lt(now()->addHours(12));

            $slots[] = [
                'start' => $slotStart,
                'end' => $slotEnd,
                'available' => !$isBooked && !$isCutOff,
                'reason' => $isCutOff ? 'cutoff' : ($isBooked ? 'booked' : null)
            ];

            $start->addMinutes($duration);
        }

        return response()->json([
            'slots' => $slots,
            'duration' => $duration,
            'day_name' => $date->locale('id')->dayName,
        ]);
    }

    public function confirmDone($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status !== 'waiting_confirmation') {
            return back()->with('error', 'Sesi ini belum ditandai selesai oleh pelatih.');
        }

        $booking->update([
            'status' => 'completed',
            'payout_status' => 'paid_to_wallet'
        ]);

        $trainer = $booking->trainerProfile;
        
        $sessionValue = $trainer->price_per_session;
        if ($booking->packagePurchase && $booking->packagePurchase->transaction) {
            $transaction = $booking->packagePurchase->transaction;
            $totalPaidToTrainer = $transaction->amount - $transaction->platform_fee;
            $sessionValue = $totalPaidToTrainer / $booking->packagePurchase->sessions_total;
        }

        $trainer->increment('wallet_balance', $sessionValue);

        return back()->with('success', 'Terima kasih telah mengonfirmasi! Sesi telah selesai. Dana diteruskan ke dompet pelatih. Jangan lupa berikan rating.');
    }
    public function disputeBooking(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
            'proof_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status !== 'waiting_confirmation') {
            return back()->with('error', 'Hanya sesi yang menunggu konfirmasi yang dapat di-komplain.');
        }

        $path = $request->hasFile('proof_photo') ? $request->file('proof_photo')->store('disputes', 'public') : null;

        \App\Models\Dispute::create([
            'booking_id' => $booking->id,
            'member_reason' => $request->reason,
            'member_proof_photo_path' => $path,
            'status' => 'open'
        ]);

        $booking->update([
            'status' => 'disputed',
            'payout_status' => 'disputed'
        ]);

        return back()->with('success', 'Gugatan komplain telah dilayangkan ke Pusat Resolusi. Menunggu jawaban dari Pelatih.');
    }
    public function cancelBooking($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Hanya sesi yang aktif (Confirmed) yang dapat dibatalkan.');
        }

        $sessionStart = \Carbon\Carbon::parse($booking->session_date->format('Y-m-d') . ' ' . $booking->start_time);
        
        if (now()->diffInHours($sessionStart, false) < 48) {
            return back()->with('error', 'Batas waktu pembatalan mandiri (H-2) sudah habis. Silakan hubungi pelatih via WhatsApp.');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        if ($booking->package_purchase_id) {
            $booking->packagePurchase->decrement('sessions_used');
        }

        return back()->with('success', 'Jadwal berhasil dibatalkan. Kuota sesi Anda telah dikembalikan.');
    }
}
