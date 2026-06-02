@extends('layouts.app')
@section('title', 'Booking — ' . $profile->user->name)

@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('trainers.show', $profile->id) }}" class="btn btn-sm btn-outline-secondary mb-4">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>

                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4"><i class="bi bi-calendar-plus me-2 text-success"></i>Booking Sesi Latihan</h3>

                            <!-- Trainer Summary -->
                            <div class="d-flex align-items-center p-3 rounded-3 mb-4" style="background:#f1f5f9;">
                                <div style="font-size:2.5rem; margin-right:1rem;">{{ $profile->category->icon ?? '💪' }}</div>
                                <div>
                                    <h5 class="fw-bold mb-0">{{ $profile->user->name }}</h5>
                                    <small class="text-muted">{{ $profile->specialization }} • {{ $profile->gym_name }}</small>
                                    <div class="price-tag mt-1" style="font-size:1.1rem;">
                                        Rp {{ number_format($profile->price_per_session, 0, ',', '.') }} <small>/sesi</small>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('bookings.store') }}">
                                @csrf
                                <input type="hidden" name="trainer_profile_id" value="{{ $profile->id }}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pilih Jadwal <span class="text-danger">*</span></label>
                                    @if($profile->schedules->isEmpty())
                                        <div class="alert alert-warning">Trainer belum memiliki jadwal tersedia.</div>
                                    @else
                                    <div class="row g-2">
                                        @foreach($profile->schedules as $schedule)
                                        <div class="col-6 col-md-4">
                                            <input type="radio" class="btn-check" name="schedule_id" id="schedule_{{ $schedule->id }}" value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'checked' : '' }} required>
                                            <label class="btn btn-outline-success w-100 text-start p-3" for="schedule_{{ $schedule->id }}" style="border-radius:0.75rem;">
                                                <strong>{{ $schedule->day_name }}</strong><br>
                                                <small>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</small>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('schedule_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Sesi <span class="text-danger">*</span></label>
                                    <input type="date" name="session_date" class="form-control" value="{{ old('session_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    @error('session_date')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Catatan (Opsional)</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Contoh: Saya pemula, ingin fokus latihan upper body...">{{ old('notes') }}</textarea>
                                </div>

                                <div class="p-3 rounded-3 mb-4" style="background:#d1fae5;">
                                    <div class="d-flex justify-content-between">
                                        <span>Biaya Sesi</span>
                                        <strong>Rp {{ number_format($profile->price_per_session, 0, ',', '.') }}</strong>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary-mylora btn-lg w-100" {{ $profile->schedules->isEmpty() ? 'disabled' : '' }}>
                                    <i class="bi bi-calendar-check me-2"></i>Lanjutkan ke Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
