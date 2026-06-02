<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PackagePurchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $activePurchases = PackagePurchase::with(['trainerPackage', 'trainerProfile.user', 'trainerProfile.category', 'transaction'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'pending'])
            ->latest()
            ->get();

        $completedPurchases = PackagePurchase::with(['trainerPackage', 'trainerProfile.user'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        $bookings = Booking::with(['trainerProfile.user', 'trainerProfile.category', 'review'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $totalBookings = Booking::where('user_id', $user->id)->count();
        $activePackages = PackagePurchase::where('user_id', $user->id)->where('status', 'active')->count();
        $completedSessions = Booking::where('user_id', $user->id)->where('status', 'completed')->count();

        return view('member.dashboard', compact(
            'activePurchases', 'completedPurchases', 'bookings',
            'totalBookings', 'activePackages', 'completedSessions'
        ));
    }
}
