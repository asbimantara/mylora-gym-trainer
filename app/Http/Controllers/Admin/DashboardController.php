<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\TrainerProfile;
use App\Models\Transaction;
use App\Models\PackagePurchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = User::where('role', 'member')->count();
        $totalTrainers = User::where('role', 'trainer')->count();
        $pendingTrainers = TrainerProfile::where('is_approved', false)->count();
        $totalTransactions = Transaction::where('status', 'success')->count();
        $totalRevenue = Transaction::where('status', 'success')->sum('amount');
        $platformEarnings = Transaction::where('status', 'success')->sum('platform_fee');

        $recentPurchases = PackagePurchase::with(['user', 'trainerProfile.user', 'trainerPackage', 'transaction'])
            ->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalMembers', 'totalTrainers', 'pendingTrainers',
            'totalTransactions', 'totalRevenue', 'platformEarnings', 'recentPurchases'
        ));
    }

    public function members()
    {
        $members = User::where('role', 'member')
            ->withCount(['packagePurchases', 'bookings'])
            ->latest()
            ->paginate(20);
        return view('admin.members', compact('members'));
    }

    public function trainers()
    {
        $trainers = TrainerProfile::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.trainers', compact('trainers'));
    }

    public function approveTrainer($id)
    {
        TrainerProfile::findOrFail($id)->update(['is_approved' => true]);
        return back()->with('success', 'Trainer berhasil diverifikasi!');
    }

    public function rejectTrainer($id)
    {
        TrainerProfile::findOrFail($id)->update(['is_approved' => false]);
        return back()->with('success', 'Trainer ditolak.');
    }

    public function reports()
    {
        $transactions = Transaction::with(['user', 'packagePurchase.trainerProfile.user', 'packagePurchase.trainerPackage'])
            ->latest()->paginate(20);
        $totalRevenue = Transaction::where('status', 'success')->sum('amount');
        $platformEarnings = Transaction::where('status', 'success')->sum('platform_fee');
        $trainerEarnings = $totalRevenue - $platformEarnings;

        return view('admin.reports', compact('transactions', 'totalRevenue', 'platformEarnings', 'trainerEarnings'));
    }
}
