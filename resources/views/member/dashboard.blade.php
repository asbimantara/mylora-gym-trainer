@extends('layouts.app')
@section('title', 'Dashboard Member')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Dashboard Member</h2>
            <p class="text-muted mb-4">Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3" style="background:#d1fae5; color:#059669;"><i class="bi bi-box-seam"></i></div>
                            <div><div class="stat-value">{{ $activePackages }}</div><small class="text-muted">Paket Aktif</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3" style="background:#dbeafe; color:#2563eb;"><i class="bi bi-calendar-check"></i></div>
                            <div><div class="stat-value">{{ $totalBookings }}</div><small class="text-muted">Total Sesi Booking</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3" style="background:#fef3c7; color:#d97706;"><i class="bi bi-check-circle"></i></div>
                            <div><div class="stat-value">{{ $completedSessions }}</div><small class="text-muted">Sesi Selesai</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Packages -->
            @if($activePurchases->isNotEmpty())
            <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-box-seam me-2 text-success"></i>Paket Aktif</h5>
                    <div class="row g-3">
                        @foreach($activePurchases as $purchase)
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $purchase->trainerProfile->user->name }}</h6>
                                        <small class="text-muted">{{ $purchase->trainerPackage->name }}</small>
                                    </div>
                                    <span class="badge bg-{{ $purchase->status_badge }}">{{ $purchase->status_label }}</span>
                                </div>
                                @if($purchase->status === 'active')
                                <div class="progress mb-2" style="height:8px; border-radius:4px;">
                                    <div class="progress-bar bg-success" style="width:{{ $purchase->progress_percent }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>{{ $purchase->sessions_used }}/{{ $purchase->sessions_total }} sesi digunakan</span>
                                    <strong>Sisa {{ $purchase->sessions_remaining }}</strong>
                                </div>
                                @if($purchase->expired_at)
                                <div class="small text-muted mb-2">
                                    <i class="bi bi-clock-history me-1"></i>Masa aktif: <strong>{{ \Carbon\Carbon::parse($purchase->expired_at)->format('d M Y') }}</strong> 
                                    @php
                                        $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($purchase->expired_at), false);
                                    @endphp
                                    <span class="text-{{ $daysLeft < 7 ? 'danger' : 'success' }}">({{ $daysLeft > 0 ? $daysLeft . ' hari lagi' : 'Habis' }})</span>
                                </div>
                                @endif
                                <a href="{{ route('bookings.book-session', $purchase->id) }}" class="btn btn-primary-mylora btn-sm w-100">
                                    <i class="bi bi-calendar-plus me-1"></i>Booking Sesi
                                </a>
                                @elseif($purchase->status === 'pending')
                                @if($purchase->transaction && $purchase->transaction->status === 'pending')
                                <form method="POST" action="{{ route('bookings.pay', $purchase->id) }}" class="mt-2">
                                    @csrf
                                    <button class="btn btn-warning btn-sm w-100"><i class="bi bi-credit-card me-1"></i>Bayar Sekarang</button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <!-- Informasi Aturan Booking -->
            <div class="alert alert-info shadow-sm mb-4 border-0" style="border-radius:1rem;">
                <h6 class="fw-bold mb-2"><i class="bi bi-info-circle-fill me-2"></i>Informasi Perubahan Jadwal (Reschedule & Batal)</h6>
                <ul class="mb-0 small">
                    <li class="mb-1"><strong>Reschedule / Pembatalan:</strong> Jika ada kendala, harap hubungi Admin atau Coach terkait maksimal <strong>H-1 (24 Jam)</strong> sebelum sesi dimulai.</li>
                    <li class="mb-1"><strong>Keadaan Darurat (Sakit/Force Majeure):</strong> Jika ada kendala mendadak di hari H, silakan gunakan tombol <span class="badge bg-success"><i class="bi bi-whatsapp"></i> Chat Pelatih</span> di tabel riwayat sesi.</li>
                    <li><strong>Kebijakan Hangus (No-Show):</strong> Keputusan pembatalan jadwal mendadak ada di tangan pelatih. Jika Anda tidak hadir tanpa konfirmasi, kuota sesi akan dinyatakan hangus.</li>
                </ul>
            </div>

            <!-- Booking History -->
            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Riwayat Sesi Latihan</h5>
                    @if($bookings->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size:2.5rem;"></i>
                            <p class="text-muted mt-2">Belum ada sesi latihan. <a href="{{ route('trainers.index') }}">Cari trainer sekarang!</a></p>
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="">
                                <tr><th>Trainer</th><th>Tanggal</th><th>Waktu</th><th>Status</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->trainerProfile->user->name }}</strong><br>
                                        <small class="text-muted">{{ $booking->trainerProfile->category->name ?? '' }}</small>
                                    </td>
                                    <td>{{ $booking->session_date->format('d M Y') }}</td>
                                    <td>{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                                    <td><span class="badge bg-{{ $booking->status_badge }} badge-status">{{ $booking->status_label }}</span></td>
                                    <td>
                                        @if($booking->status === 'completed' && !$booking->review)
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $booking->id }}">
                                            <i class="bi bi-star"></i> Review
                                        </button>
                                        @endif
                                        @if($booking->review)
                                        <span class="badge bg-secondary-subtle text-body"><i class="bi bi-star-fill text-warning"></i> {{ $booking->review->rating }}/5</span>
                                        @endif
                                        @if(in_array($booking->status, ['pending', 'confirmed']))
                                            @php
                                                $waPhone = preg_replace('/[^0-9]/', '', $booking->trainerProfile->phone ?? $booking->trainerProfile->user->phone);
                                                if (str_starts_with($waPhone, '0')) {
                                                    $waPhone = '62' . substr($waPhone, 1);
                                                }
                                                $waText = urlencode("Halo Coach " . $booking->trainerProfile->user->name . ",\nSaya " . auth()->user()->name . ". Terkait jadwal sesi saya pada " . $booking->session_date->format('d M Y') . " jam " . substr($booking->start_time, 0, 5) . ", saya ingin bertanya/menginfokan sesuatu.");
                                            @endphp
                                        @endif
                                        @if($booking->status === 'confirmed')
                                            @php
                                                $sessionStart = \Carbon\Carbon::parse($booking->session_date->format('Y-m-d') . ' ' . $booking->start_time);
                                                $hoursLeft = now()->diffInHours($sessionStart, false);
                                            @endphp
                                            @php
                                                $phoneRaw = preg_replace('/[^0-9]/', '', $booking->trainerProfile->user->phone ?? '08123456789');
                                                if (str_starts_with($phoneRaw, '0')) {
                                                    $phoneRaw = '62' . substr($phoneRaw, 1);
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $phoneRaw }}" target="_blank" class="btn btn-sm btn-outline-success w-100 mb-2">
                                                <i class="bi bi-whatsapp me-1"></i> Chat Pelatih
                                            </a>

                                            @if($hoursLeft >= 48)
                                                <form method="POST" action="{{ route('member.booking.cancel', $booking->id) }}">
                                                    @csrf @method('PUT')
                                                    <button type="button" class="btn btn-sm btn-outline-danger w-100" data-confirm="Batalkan jadwal ini? Kuota sesi akan dikembalikan ke paket Anda.">
                                                        <i class="bi bi-x-circle me-1"></i> Batalkan Jadwal (H-2)
                                                    </button>
                                                </form>
                                            @else
                                                <small class="text-danger d-block text-center mt-1" style="font-size: 0.7rem;">Batas pembatalan (H-2) habis. Hubungi pelatih.</small>
                                            @endif
                                        @elseif($booking->status === 'waiting_confirmation')
                                        <div class="mt-3 p-3 border rounded shadow-sm border-success-subtle">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-shield-check text-success fs-5 me-2"></i>
                                                <strong class="mb-0">Laporan Pelatih</strong>
                                            </div>
                                            <div class="mb-3 px-3 py-2 rounded bg-success-subtle text-success-emphasis" style="font-size: 0.85rem;">
                                                <i class="bi bi-journal-text me-1"></i> {{ $booking->notes ?? 'Tidak ada catatan.' }}
                                            </div>
                                            
                                            <div class="d-flex gap-2 mb-2">
                                                @if($booking->proof_photo_path)
                                                    <a href="{{ Storage::url($booking->proof_photo_path) }}" target="_blank" class="btn btn-sm btn-outline-info flex-fill">
                                                        <i class="bi bi-image"></i> Lihat Bukti
                                                    </a>
                                                @endif
                                                <form method="POST" action="{{ route('member.booking.confirm_done', $booking->id) }}" class="flex-fill d-flex m-0">
                                                    @csrf @method('PUT')
                                                    <button class="btn btn-sm btn-success w-100 fw-bold shadow-sm">
                                                        <i class="bi bi-check2-circle me-1"></i> ACC Selesai
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-danger flex-fill" data-bs-toggle="modal" data-bs-target="#disputeModal{{ $booking->id }}">
                                                    <i class="bi bi-exclamation-triangle"></i> Komplain
                                                </button>
                                            </div>
                                            <small class="text-muted d-block mt-2 text-center" style="font-size: 0.7rem;">(Dana pelatih akan cair otomatis dlm 2x24 Jam jika tidak ada respon)</small>
                                        </div>

                                        <!-- Modal Komplain -->
                                        <div class="modal fade" id="disputeModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('member.booking.dispute', $booking->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title fw-bold text-danger">Pusat Resolusi: Ajukan Komplain</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <p class="text-muted small mb-3">Dana pencairan akan dibekukan sementara. Admin akan menjadi penengah antara Anda dan pelatih.</p>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Alasan Komplain</label>
                                                                <textarea name="reason" rows="3" class="form-control" required placeholder="Misal: Pelatih membatalkan jadwal secara sepihak..."></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Upload Foto Bukti (Opsional)</label>
                                                                <input type="file" name="proof_photo" class="form-control" accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Kirim Komplain</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif($booking->status === 'disputed')
                                        <div class="mt-2">
                                            <span class="badge bg-danger text-white"><i class="bi bi-exclamation-triangle me-1"></i>Dispute (Komplain Aktif)</span>
                                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Menunggu keputusan Admin</small>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @if($booking->status === 'completed' && !$booking->review)
                                <div class="modal fade" id="reviewModal{{ $booking->id }}" tabindex="-1">
                                    <div class="modal-dialog"><div class="modal-content" style="border-radius:1rem;">
                                        <div class="modal-header border-0"><h5 class="modal-title fw-bold">Beri Ulasan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <form method="POST" action="{{ route('reviews.store', $booking->id) }}">@csrf
                                            <div class="modal-body">
                                                <p class="text-muted">Ulasan untuk <strong>{{ $booking->trainerProfile->user->name }}</strong></p>
                                                <div class="mb-3"><label class="form-label fw-semibold">Rating</label>
                                                    <select name="rating" class="form-select" required>
                                                        <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                                        <option value="4">⭐⭐⭐⭐ Baik</option>
                                                        <option value="3">⭐⭐⭐ Cukup</option>
                                                        <option value="2">⭐⭐ Kurang</option>
                                                        <option value="1">⭐ Buruk</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3"><label class="form-label fw-semibold">Komentar</label><textarea name="comment" class="form-control" rows="3"></textarea></div>
                                            </div>
                                            <div class="modal-footer border-0"><button type="submit" class="btn btn-primary-mylora">Kirim Ulasan</button></div>
                                        </form>
                                    </div></div>
                                </div>
                                @endif
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
@endsection
