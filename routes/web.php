<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/trainers/{id}', [TrainerController::class, 'show'])->name('trainers.show');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Member
    Route::middleware('role:member')->prefix('member')->group(function () {
        // Onboarding
        Route::get('/onboarding', [App\Http\Controllers\Member\OnboardingController::class, 'index'])->name('member.onboarding');
        Route::post('/onboarding', [App\Http\Controllers\Member\OnboardingController::class, 'process'])->name('member.onboarding.process');

        Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('member.dashboard');
        
        Route::put('/bookings/{id}/confirm-done', [BookingController::class, 'confirmDone'])->name('member.booking.confirm_done');
        Route::post('/bookings/{id}/dispute', [BookingController::class, 'disputeBooking'])->name('member.booking.dispute');
        Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('member.booking.cancel');

        // Package purchase flow
        Route::get('/book/{trainer}/packages', [BookingController::class, 'selectPackage'])->name('bookings.select-package');
        Route::post('/book/{trainer}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
        Route::post('/purchase/{purchase}/pay', [BookingController::class, 'pay'])->name('bookings.pay');

        // Individual session booking
        Route::get('/purchase/{purchase}/book-session', [BookingController::class, 'bookSession'])->name('bookings.book-session');
        Route::post('/purchase/{purchase}/book-session', [BookingController::class, 'storeSession'])->name('bookings.store-session');

        // Reviews
        Route::post('/reviews/{booking}', [ReviewController::class, 'store'])->name('reviews.store');
    });

    // API for time slots (member only)
    Route::middleware('role:member')->get('/api/trainers/{trainer}/slots', [BookingController::class, 'getAvailableSlots'])->name('api.trainer.slots');

    // Trainer
    Route::middleware('role:trainer')->prefix('trainer')->group(function () {
        Route::get('/dashboard', [TrainerDashboard::class, 'index'])->name('trainer.dashboard');
        Route::get('/profile', [TrainerDashboard::class, 'profile'])->name('trainer.profile');
        Route::put('/profile', [TrainerDashboard::class, 'updateProfile'])->name('trainer.profile.update');

        Route::get('/availability', [TrainerDashboard::class, 'availability'])->name('trainer.availability');
        Route::post('/availability', [TrainerDashboard::class, 'storeAvailability'])->name('trainer.availability.store');
        Route::delete('/availability/{id}', [TrainerDashboard::class, 'deleteAvailability'])->name('trainer.availability.delete');

        Route::get('/packages', [TrainerDashboard::class, 'packages'])->name('trainer.packages');
        Route::post('/packages', [TrainerDashboard::class, 'storePackage'])->name('trainer.packages.store');
        Route::delete('/packages/{id}', [TrainerDashboard::class, 'deletePackage'])->name('trainer.packages.delete');

        Route::put('/bookings/{id}/confirm', [TrainerDashboard::class, 'confirmBooking'])->name('trainer.booking.confirm');
        Route::put('/bookings/{id}/complete', [TrainerDashboard::class, 'completeBooking'])->name('trainer.booking.complete');
        Route::put('/bookings/{id}/cancel', [TrainerDashboard::class, 'cancelBooking'])->name('trainer.booking.cancel');
        Route::post('/bookings/{id}/dispute-reply', [TrainerDashboard::class, 'answerDispute'])->name('trainer.booking.dispute_reply');
        Route::post('/withdraw', [TrainerDashboard::class, 'withdraw'])->name('trainer.withdraw');
    });

    // Admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/members', [AdminDashboard::class, 'members'])->name('admin.members');
        Route::get('/trainers', [AdminDashboard::class, 'trainers'])->name('admin.trainers');
        Route::put('/trainers/{id}/approve', [AdminDashboard::class, 'approveTrainer'])->name('admin.trainer.approve');
        Route::put('/trainers/{id}/reject', [AdminDashboard::class, 'rejectTrainer'])->name('admin.trainer.reject');
        Route::get('/reports', [AdminDashboard::class, 'reports'])->name('admin.reports');
        
        // Payout Verifications & Force Complete & Dispute Resolution
        Route::get('/payouts', [App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('admin.payouts');
        Route::put('/payouts/{id}/force-complete', [App\Http\Controllers\Admin\PayoutController::class, 'forceComplete'])->name('admin.payouts.force_complete');
        Route::put('/payouts/{id}/resolve-member', [App\Http\Controllers\Admin\PayoutController::class, 'resolveMember'])->name('admin.payouts.resolve_member');
        Route::put('/payouts/{id}/resolve-trainer', [App\Http\Controllers\Admin\PayoutController::class, 'resolveTrainer'])->name('admin.payouts.resolve_trainer');

        // Withdrawals
        Route::get('/withdrawals', [App\Http\Controllers\Admin\PayoutController::class, 'withdrawals'])->name('admin.withdrawals');
        Route::put('/withdrawals/{id}/complete', [App\Http\Controllers\Admin\PayoutController::class, 'markWithdrawalCompleted'])->name('admin.withdrawals.complete');
    });
});

Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isTrainer()) return redirect()->route('trainer.dashboard');
    return redirect()->route('member.dashboard');
})->name('dashboard');
