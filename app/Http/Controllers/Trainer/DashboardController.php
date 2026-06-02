<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TrainerProfile;
use App\Models\TrainerPackage;
use App\Models\TrainerAvailability;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->trainerProfile;

        if (!$profile) {
            return view('trainer.setup');
        }

        $bookings = Booking::with(['user', 'packagePurchase.trainerPackage'])
            ->where('trainer_profile_id', $profile->id)
            ->latest()
            ->paginate(10);

        $totalBookings = Booking::where('trainer_profile_id', $profile->id)->count();
        $pendingBookings = Booking::where('trainer_profile_id', $profile->id)->where('status', 'pending')->count();
        $totalEarnings = Transaction::whereHas('packagePurchase', fn($q) => $q->where('trainer_profile_id', $profile->id))
            ->where('status', 'success')->sum('amount');

        // Generate Calendar Events
        $allBookings = Booking::with('user')->where('trainer_profile_id', $profile->id)->get();
        $calendarEvents = [];
        foreach ($allBookings as $b) {
            $color = '#3b82f6'; // primary (confirmed)
            if ($b->status === 'pending') $color = '#f59e0b'; // warning
            if ($b->status === 'completed') $color = '#10b981'; // success
            if ($b->status === 'cancelled') $color = '#ef4444'; // danger

            $calendarEvents[] = [
                'title' => $b->user->name . ' (' . substr($b->start_time, 0, 5) . ')',
                'start' => $b->session_date->format('Y-m-d') . 'T' . $b->start_time,
                'end' => $b->session_date->format('Y-m-d') . 'T' . $b->end_time,
                'color' => $color,
            ];
        }

        return view('trainer.dashboard', compact('profile', 'bookings', 'totalBookings', 'pendingBookings', 'totalEarnings', 'calendarEvents'));
    }

    public function profile()
    {
        $profile = auth()->user()->trainerProfile;
        $categories = \App\Models\Category::all();
        return view('trainer.profile', compact('profile', 'categories'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'bio' => 'required|string|max:2000',
            'specialization' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'experience_years' => 'required|integer|min:0',
            'price_per_session' => 'required|numeric|min:0',
            'session_duration' => 'required|integer|in:30,45,60,90,120',
            'location' => 'required|string|max:255',
            'gym_name' => 'required|string|max:255',
            'certifications' => 'nullable|string|max:500',
            'phone' => 'required|string|max:20',
        ]);

        $user = auth()->user();
        $profile = $user->trainerProfile;

        if (!$profile) {
            $profile = new TrainerProfile();
            $profile->user_id = $user->id;
            $profile->is_approved = false;
        }

        $profile->fill($request->only([
            'bio', 'specialization', 'category_id', 'experience_years',
            'price_per_session', 'session_duration', 'location', 'gym_name', 'certifications', 'phone'
        ]));
        $profile->save();

        return redirect()->route('trainer.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    // === AVAILABILITY (Working Hours) ===
    public function availability()
    {
        $profile = auth()->user()->trainerProfile;
        if (!$profile) return redirect()->route('trainer.profile')->with('error', 'Lengkapi profil terlebih dahulu.');

        $availabilities = $profile->availabilities()->orderBy('day_of_week')->get();
        return view('trainer.availability', compact('availabilities', 'profile'));
    }

    public function storeAvailability(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_hour' => 'required',
            'end_hour' => 'required|after:start_hour',
        ]);
        $profile = auth()->user()->trainerProfile;

        // Prevent duplicate day
        $existing = TrainerAvailability::where('trainer_profile_id', $profile->id)
            ->where('day_of_week', $request->day_of_week)->first();
        if ($existing) {
            $existing->update([
                'start_hour' => $request->start_hour,
                'end_hour' => $request->end_hour,
                'is_available' => true,
            ]);
            return back()->with('success', 'Jadwal hari tersebut diperbarui!');
        }

        TrainerAvailability::create([
            'trainer_profile_id' => $profile->id,
            'day_of_week' => $request->day_of_week,
            'start_hour' => $request->start_hour,
            'end_hour' => $request->end_hour,
            'is_available' => true,
        ]);
        return back()->with('success', 'Jam kerja berhasil ditambahkan!');
    }

    public function deleteAvailability($id)
    {
        $profile = auth()->user()->trainerProfile;
        TrainerAvailability::where('trainer_profile_id', $profile->id)->findOrFail($id)->delete();
        return back()->with('success', 'Jam kerja berhasil dihapus.');
    }

    // === PACKAGES ===
    public function packages()
    {
        $profile = auth()->user()->trainerProfile;
        if (!$profile) return redirect()->route('trainer.profile');

        $packages = $profile->packages()->orderBy('session_count')->get();
        return view('trainer.packages', compact('packages', 'profile'));
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'session_count' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'benefits' => 'nullable|string|max:1000',
        ]);
        $profile = auth()->user()->trainerProfile;

        TrainerPackage::create([
            'trainer_profile_id' => $profile->id,
            'name' => $request->name,
            'session_count' => $request->session_count,
            'price' => $request->price,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'is_active' => true,
        ]);
        return back()->with('success', 'Paket berhasil ditambahkan!');
    }

    public function deletePackage($id)
    {
        $profile = auth()->user()->trainerProfile;
        TrainerPackage::where('trainer_profile_id', $profile->id)->findOrFail($id)->delete();
        return back()->with('success', 'Paket berhasil dihapus.');
    }

    // === BOOKING MANAGEMENT ===
    public function confirmBooking($id)
    {
        $profile = auth()->user()->trainerProfile;
        Booking::where('trainer_profile_id', $profile->id)->findOrFail($id)->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking dikonfirmasi!');
    }

    public function completeBooking(Request $request, $id)
    {
        $request->validate([
            'proof_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'attendance_status' => 'required|in:hadir,no_show'
        ]);

        $profile = auth()->user()->trainerProfile;
        $booking = Booking::where('trainer_profile_id', $profile->id)->findOrFail($id);

        $path = $request->file('proof_photo')->store('proofs', 'public');
        
        $notes = "Status Kehadiran Member: " . ($request->attendance_status === 'hadir' ? "Hadir (Sesi Terlaksana)" : "Tidak Hadir (No-Show)");

        $booking->update([
            'status' => 'waiting_confirmation',
            'payout_status' => 'pending_member',
            'proof_photo_path' => $path,
            'notes' => $notes
        ]);

        return back()->with('success', 'Sesi ditandai selesai beserta bukti foto. Menunggu ACC dari Member (Maksimal 2x24 Jam).');
    }

    public function cancelBooking($id)
    {
        $profile = auth()->user()->trainerProfile;
        $booking = Booking::where('trainer_profile_id', $profile->id)->findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        // Return session credit
        if ($booking->package_purchase_id) {
            $booking->packagePurchase->decrement('sessions_used');
        }
        return back()->with('success', 'Booking dibatalkan. Kredit sesi dikembalikan.');
    }
    public function answerDispute(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000'
        ]);

        $profile = auth()->user()->trainerProfile;
        $booking = Booking::where('trainer_profile_id', $profile->id)->findOrFail($id);

        if ($booking->status !== 'disputed' || !$booking->dispute) {
            return back()->with('error', 'Sesi ini tidak dalam masa sengketa.');
        }

        $booking->dispute->update([
            'trainer_reply' => $request->reply,
            'status' => 'answered'
        ]);

        return back()->with('success', 'Pembelaan Anda telah dikirim. Menunggu putusan dari Hakim (Admin).');
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        $profile = auth()->user()->trainerProfile;

        if ($request->amount > $profile->wallet_balance) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $profile->decrement('wallet_balance', $request->amount);

        \App\Models\Withdrawal::create([
            'trainer_profile_id' => $profile->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Permintaan tarik dana berhasil diajukan. Admin akan mentransfer dana maksimal 1x24 Jam.');
    }
}
