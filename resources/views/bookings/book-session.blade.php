@extends('layouts.app')
@section('title', 'Booking Sesi Latihan')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('member.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-4"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4"><i class="bi bi-calendar-plus me-2 text-success"></i>Booking Sesi Latihan</h3>

                            <!-- Package Info -->
                            <div class="d-flex align-items-center p-3 rounded-3 mb-4" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">
                                <div style="font-size:2.5rem; margin-right:1rem;">{{ $profile->category->icon ?? '💪' }}</div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-0">{{ $profile->user->name }}</h5>
                                    <small class="text-muted">{{ $purchase->trainerPackage->name }} • {{ $profile->session_duration_hours }}/sesi</small>
                                    <div class="mt-1">
                                        <div class="progress" style="height:8px; border-radius:4px;">
                                            <div class="progress-bar bg-success" style="width:{{ $purchase->progress_percent }}%"></div>
                                        </div>
                                        <small class="text-muted">Sesi {{ $purchase->sessions_used }}/{{ $purchase->sessions_total }} — Sisa <strong>{{ $purchase->sessions_remaining }}</strong> sesi</small>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('bookings.store-session', $purchase->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pilih Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="session_date" id="sessionDate" class="form-control" value="{{ old('session_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    @error('session_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    <small class="text-muted">
                                        Hari tersedia:
                                        @foreach($availabilities as $a)
                                            <span class="badge bg-secondary-subtle text-body border">{{ $a->day_name }}</span>
                                        @endforeach
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pilih Jam <span class="text-danger">*</span></label>
                                    <div id="slotsContainer">
                                        <p class="text-muted small">Pilih tanggal terlebih dahulu untuk melihat slot waktu tersedia.</p>
                                    </div>
                                    <input type="hidden" name="start_time" id="selectedTime" required>
                                    @error('start_time')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Catatan (Opsional)</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Ingin fokus latihan upper body...">{{ old('notes') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary-mylora btn-lg w-100" id="submitBtn" disabled>
                                    <i class="bi bi-calendar-check me-2"></i>Konfirmasi Booking Sesi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
document.getElementById('sessionDate').addEventListener('change', function() {
    const date = this.value;
    const trainerId = {{ $profile->id }};
    const container = document.getElementById('slotsContainer');
    const selectedTimeInput = document.getElementById('selectedTime');
    const submitBtn = document.getElementById('submitBtn');

    container.innerHTML = '<p class="text-muted small">Memuat slot waktu...</p>';
    selectedTimeInput.value = '';
    submitBtn.disabled = true;

    fetch(`/api/trainers/${trainerId}/slots?date=${date}`)
        .then(r => r.json())
        .then(data => {
            if (!data.slots || data.slots.length === 0) {
                container.innerHTML = `<div class="alert alert-warning small"><i class="bi bi-exclamation-triangle me-1"></i>Trainer tidak tersedia pada hari <strong>${data.day_name || 'ini'}</strong>. Silakan pilih tanggal lain.</div>`;
                return;
            }

            let html = `<p class="small text-muted mb-2">${data.day_name} — Durasi: ${data.duration} menit/sesi</p><div class="row g-2">`;
            data.slots.forEach((slot, i) => {
                const disabled = !slot.available;
                const badgeClass = disabled ? 'btn-outline-secondary' : 'btn-outline-success';
                let disabledText = '';
                if (disabled) {
                    disabledText = slot.reason === 'cutoff' ? '<br><small class="text-danger">Terlalu Mendadak</small>' : '<br><small class="text-danger">Terbooking</small>';
                }
                html += `
                    <div class="col-4 col-md-3">
                        <button type="button"
                            class="btn ${badgeClass} w-100 slot-btn p-2"
                            data-time="${slot.start}"
                            ${disabled ? 'disabled' : ''}
                            style="border-radius:0.75rem; font-size:0.85rem;">
                            ${slot.start} - ${slot.end}
                            ${disabledText}
                        </button>
                    </div>`;
            });
            html += '</div>';
            container.innerHTML = html;

            // Click handler for slots
            document.querySelectorAll('.slot-btn:not([disabled])').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('btn-success', 'text-white'));
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success', 'text-white');
                    selectedTimeInput.value = this.dataset.time;
                    submitBtn.disabled = false;
                });
            });
        })
        .catch(() => {
            container.innerHTML = '<div class="alert alert-danger small">Gagal memuat slot. Coba lagi.</div>';
        });
});
</script>
@endpush
@endsection
