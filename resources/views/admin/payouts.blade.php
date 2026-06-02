@extends('layouts.app')
@section('title', 'Verifikasi Bukti Latihan')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Verifikasi Bukti Latihan (QC)</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard</a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Daftar sesi yang sudah ditandai selesai oleh pelatih, namun belum di-ACC oleh Member. Jika sudah lewat dari 2x24 jam, Anda berhak mencairkan uang pelatih secara paksa (Auto-Complete).</p>
                    
                    @if($bookings->isEmpty())
                        <div class="alert alert-info text-center py-4">Belum ada sesi latihan yang menggantung (menunggu konfirmasi member).</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="">
                                    <tr>
                                        <th>Tanggal Sesi</th>
                                        <th>Pelatih</th>
                                        <th>Member</th>
                                        <th>Status Payout</th>
                                        <th>Aksi Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->session_date->format('d M Y') }}<br><small class="text-muted">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</small></td>
                                        <td><strong>{{ $booking->trainerProfile->user->name }}</strong></td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>
                                            @if($booking->status === 'disputed')
                                                <span class="badge bg-danger text-white"><i class="bi bi-exclamation-triangle me-1"></i>SENGKETA (DISPUTE)</span>
                                                <div class="mt-3 p-3 rounded shadow-sm border border-danger-subtle bg-danger-subtle text-danger-emphasis" style="max-width: 300px;">
                                                    <span class="d-block small fw-bold text-danger mb-1"><i class="bi bi-person-fill-exclamation me-1"></i>Gugatan Member:</span>
                                                    <span class="d-block small mb-2 fst-italic">"{{ $booking->dispute->member_reason ?? '-' }}"</span>
                                                    @if($booking->dispute && $booking->dispute->member_proof_photo_path)
                                                        <a href="{{ Storage::url($booking->dispute->member_proof_photo_path) }}" target="_blank" class="small text-danger fw-bold text-decoration-none"><i class="bi bi-image me-1"></i>Lihat Bukti Member</a>
                                                    @endif
                                                    
                                                    <hr class="my-2 border-danger opacity-25">
                                                    
                                                    <span class="d-block small fw-bold text-primary mb-1"><i class="bi bi-person-badge-fill me-1"></i>Pembelaan Pelatih:</span>
                                                    @if($booking->dispute && $booking->dispute->status === 'open')
                                                        <span class="d-block small text-muted fst-italic">Menunggu jawaban pelatih...</span>
                                                    @else
                                                        <span class="d-block small mb-2 fst-italic">"{{ $booking->dispute->trainer_reply ?? '-' }}"</span>
                                                        @if($booking->proof_photo_path)
                                                            <a href="{{ Storage::url($booking->proof_photo_path) }}" target="_blank" class="small text-primary fw-bold text-decoration-none"><i class="bi bi-image me-1"></i>Lihat Bukti Awal Pelatih</a>
                                                        @else
                                                            <span class="small text-muted fst-italic"><i class="bi bi-image-alt me-1"></i>Pelatih tidak melampirkan bukti foto</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu ACC Member</span>
                                                <br>
                                                <small class="text-muted" style="font-size: 0.75rem;">Sejak: {{ $booking->updated_at->diffForHumans() }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->status === 'disputed')
                                                @if($booking->dispute && $booking->dispute->status === 'open')
                                                    <button class="btn btn-sm btn-secondary w-100" disabled>Tunggu Pelatih Menjawab</button>
                                                @else
                                                    <div class="d-grid gap-2">
                                                        <form method="POST" action="{{ route('admin.payouts.resolve_member', $booking->id) }}">
                                                            @csrf @method('PUT')
                                                            <button type="button" class="btn btn-sm btn-danger w-100" data-confirm="Yakin memenangkan Member? Sesi akan dibatalkan dan dana kembali ke kuota.">Bela Member (Refund Sesi)</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.payouts.resolve_trainer', $booking->id) }}">
                                                            @csrf @method('PUT')
                                                            <button type="button" class="btn btn-sm btn-primary-mylora w-100" data-confirm="Yakin memenangkan Pelatih? Dana akan dicairkan ke saldo pelatih.">Bela Pelatih (Cairkan Dana)</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @else
                                                <form method="POST" action="{{ route('admin.payouts.force_complete', $booking->id) }}">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-shield-check me-1"></i>Force Complete (Lewat 48 Jam)</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
