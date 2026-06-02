<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class PayoutController extends Controller
{
    public function index()
    {
        // Get bookings waiting for member confirmation or disputed
        $bookings = Booking::with(['user', 'trainerProfile.user', 'dispute'])
            ->whereIn('status', ['waiting_confirmation', 'disputed'])
            ->orderBy('updated_at', 'asc') // Oldest first
            ->paginate(15);
            
        return view('admin.payouts', compact('bookings'));
    }

    public function forceComplete($id)
    {
        $booking = Booking::findOrFail($id);
        
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
        
        return back()->with('success', 'Sesi di-Force Complete (Auto-ACC 2x24 Jam). Dana diteruskan ke dompet pelatih.');
    }

    public function resolveMember($id)
    {
        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'status' => 'cancelled',
            'payout_status' => null
        ]);

        if ($booking->dispute) {
            $booking->dispute->update(['status' => 'resolved']);
        }
        
        return back()->with('success', 'Sengketa diselesaikan: Member menang. Silakan hubungi member via WhatsApp untuk memproses transfer Refund secara manual 1x24 jam.');
    }

    public function resolveTrainer($id)
    {
        $booking = Booking::findOrFail($id);
        
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

        if ($booking->dispute) {
            $booking->dispute->update(['status' => 'resolved']);
        }
        
        return back()->with('success', 'Sengketa diselesaikan: Pelatih menang. Dana diteruskan ke dompet pelatih.');
    }

    public function withdrawals()
    {
        $withdrawals = \App\Models\Withdrawal::with('trainerProfile.user')
            ->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'completed' THEN 2 WHEN 'rejected' THEN 3 ELSE 4 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function markWithdrawalCompleted($id)
    {
        $withdrawal = \App\Models\Withdrawal::findOrFail($id);
        
        $withdrawal->update(['status' => 'completed']);
        
        return back()->with('success', 'Penarikan dana ditandai sukses. Trainer akan melihat statusnya berubah.');
    }
}
