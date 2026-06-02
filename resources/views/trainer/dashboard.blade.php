@extends('layouts.app')
@section('title', 'Dashboard Trainer')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard Trainer</h2>
                    <p class="text-muted mb-0">{{ auth()->user()->name }} • {{ $profile->specialization }}</p>
                </div>
                <div>
                    <a href="{{ route('trainer.packages') }}" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-box-seam me-1"></i>Paket Latihan</a>
                    <a href="{{ route('trainer.availability') }}" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-clock me-1"></i>Jam Kerja</a>
                    <a href="{{ route('trainer.profile') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-person me-1"></i>Profil</a>
                </div>
            </div>

            @if(!$profile->is_approved)
            <div class="alert alert-warning alert-mylora mb-4" style="border-left-color:#f59e0b;">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>Profil Belum Diverifikasi.</strong> Admin sedang mereview profil kamu. Kamu belum bisa menerima booking.
            </div>
            @endif

            <!-- Stats -->
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3" style="background:#d1fae5; color:#059669;"><i class="bi bi-calendar-check"></i></div>
                            <div><div class="stat-value">{{ $totalBookings }}</div><small class="text-muted">Total Sesi Booking</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3" style="background:#fef3c7; color:#d97706;"><i class="bi bi-hourglass-split"></i></div>
                            <div><div class="stat-value">{{ $pendingBookings }}</div><small class="text-muted">Menunggu Konfirmasi</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3" style="background:#dbeafe; color:#2563eb;"><i class="bi bi-wallet2"></i></div>
                            <div>
                                <div class="stat-value">Rp {{ number_format($profile->wallet_balance ?? 0, 0, ',', '.') }}</div>
                                <small class="text-muted">Saldo Tersedia</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wallet & Withdraw Section -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="border-radius:1rem; height: 100%;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-cash-stack text-success me-2"></i>Tarik Dana (Withdraw)</h5>
                            <p class="text-muted small mb-4">Cairkan saldo Anda ke rekening bank. Proses transfer oleh admin maksimal 1x24 jam kerja.</p>
                            
                            <form method="POST" action="{{ route('trainer.withdraw') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nominal Tarik Dana</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 border-secondary"><strong class="text-white-50">Rp</strong></span>
                                        <input type="number" name="amount" class="form-control border-secondary" placeholder="Minimal Rp 50.000" min="50000" max="{{ $profile->wallet_balance ?? 0 }}" required>
                                    </div>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nama Bank</label>
                                        <input type="text" name="bank_name" class="form-control" placeholder="BCA / Mandiri" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Nomor Rekening</label>
                                        <input type="text" name="account_number" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nama Pemilik Rekening</label>
                                    <input type="text" name="account_name" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary-mylora w-100" {{ ($profile->wallet_balance ?? 0) < 50000 ? 'disabled' : '' }}>Ajukan Penarikan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="border-radius:1rem; height: 100%;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history text-secondary me-2"></i>Riwayat Penarikan</h5>
                            @if($profile->withdrawals->isEmpty())
                                <div class="text-center text-muted py-4"><i class="bi bi-inbox fs-4 d-block mb-2"></i>Belum ada riwayat penarikan dana.</div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nominal</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($profile->withdrawals()->latest()->take(5)->get() as $wd)
                                            <tr>
                                                <td>{{ $wd->created_at->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($wd->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($wd->status === 'completed')
                                                        <span class="badge bg-success">Sukses</span>
                                                    @else
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-muted d-block text-center mt-2">Menampilkan 5 penarikan terakhir.</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- FullCalendar -->
            <div class="card border-0 shadow-sm mb-5" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-calendar-week text-primary me-2"></i>Kalender Jadwal Anda</h5>
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- Bookings -->
            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Daftar Sesi Latihan</h5>
                    @if($bookings->isEmpty())
                        <p class="text-muted text-center py-3">Belum ada booking masuk.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="">
                                <tr><th>Member</th><th>Paket</th><th>Tanggal</th><th>Waktu</th><th>Status</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td><strong>{{ $booking->user->name }}</strong></td>
                                    <td><small>{{ $booking->packagePurchase->trainerPackage->name ?? '-' }}</small></td>
                                    <td>{{ $booking->session_date->format('d M Y') }}</td>
                                    <td>{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                                    <td><span class="badge bg-{{ $booking->status_badge }} badge-status">{{ $booking->status_label }}</span></td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <form method="POST" action="{{ route('trainer.booking.confirm', $booking->id) }}" class="d-inline">@csrf @method('PUT')
                                                <button class="btn btn-sm btn-success" title="Konfirmasi"><i class="bi bi-check"></i></button>
                                            </form>
                                            <form method="POST" action="{{ route('trainer.booking.cancel', $booking->id) }}" class="d-inline">@csrf @method('PUT')
                                                <button class="btn btn-sm btn-danger" title="Batalkan"><i class="bi bi-x"></i></button>
                                            </form>
                                        @elseif($booking->status === 'confirmed')
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#completeModal{{ $booking->id }}">
                                                Tandai Selesai
                                            </button>

                                            <!-- Modal Upload Bukti & No Show -->
                                            <div class="modal fade" id="completeModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('trainer.booking.complete', $booking->id) }}" enctype="multipart/form-data">
                                                            @csrf @method('PUT')
                                                            <div class="modal-header border-0">
                                                                <h5 class="modal-title fw-bold">Laporan Sesi Latihan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Status Kehadiran Member</label>
                                                                    <select name="attendance_status" class="form-select" required>
                                                                        <option value="hadir">Member Hadir (Sesi Berjalan Lancar)</option>
                                                                        <option value="no_show">Member Tidak Hadir / Ghosting (No-Show)</option>
                                                                    </select>
                                                                    <small class="text-muted mt-1 d-block">Jika member <em>ghosting</em>, Anda tetap berhak menerima pembayaran penuh.</small>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Upload Foto Bukti (Wajib)</label>
                                                                    <input type="file" name="proof_photo" class="form-control" accept="image/*" required>
                                                                    <small class="text-muted mt-1 d-block">Jika Hadir: Foto <em>selfie</em> Anda bersama Member.<br>Jika No-Show: Foto <em>selfie</em> Anda sendirian di lokasi Gym sebagai bukti Anda sudah datang.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary-mylora">Kirim & Tunggu ACC Member</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($booking->status === 'waiting_confirmation')
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu ACC Member</span>
                                        @elseif($booking->status === 'disputed')
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#replyDisputeModal{{ $booking->id }}">
                                                <i class="bi bi-exclamation-triangle me-1"></i> Jawab Komplain Member
                                            </button>

                                            <!-- Modal Jawab Komplain -->
                                            <div class="modal fade" id="replyDisputeModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('trainer.booking.dispute_reply', $booking->id) }}">
                                                            @csrf
                                                            <div class="modal-header border-0">
                                                                <h5 class="modal-title fw-bold text-danger">Pusat Resolusi: Hak Jawab Pelatih</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
                                                                <div class="p-3 mb-3 border rounded shadow-sm border-danger-subtle">
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <i class="bi bi-exclamation-octagon text-danger fs-5 me-2"></i>
                                                                        <strong class="mb-0 text-danger">Tuduhan / Komplain Member:</strong>
                                                                    </div>
                                                                    <div class="px-3 py-2 rounded bg-danger-subtle text-danger-emphasis" style="font-size: 0.85rem;">
                                                                        "{{ $booking->dispute->member_reason ?? '-' }}"
                                                                    </div>
                                                                </div>
                                                                @if($booking->dispute && $booking->dispute->status === 'answered')
                                                                    <div class="alert alert-success small">Anda sudah mengirimkan pembelaan. Menunggu keputusan Admin.</div>
                                                                @else
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Pembelaan Anda</label>
                                                                        <textarea name="reply" rows="3" class="form-control" required placeholder="Jelaskan versi Anda di sini. Admin akan menilai..."></textarea>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                                                @if(!$booking->dispute || $booking->dispute->status === 'open')
                                                                <button type="submit" class="btn btn-danger">Kirim Pembelaan ke Admin</button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $bookings->links() }}
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            slotMinTime: '06:00:00',
            slotMaxTime: '22:00:00',
            allDaySlot: false,
            events: @json($calendarEvents),
            eventClick: function(info) {
                alert('Sesi: ' + info.event.title + '\nWaktu: ' + info.event.start.toLocaleTimeString());
            }
        });
        calendar.render();
    });
</script>
@endpush
@endsection
