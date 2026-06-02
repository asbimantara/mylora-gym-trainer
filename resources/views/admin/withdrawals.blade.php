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
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelatih</th>
                                    <th>Nominal</th>
                                    <th>Tujuan Transfer</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $wd)
                                    <tr>
                                        <td>
                                            {{ $wd->created_at->format('d M Y H:i') }}<br>
                                            <small class="text-muted">{{ $wd->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $wd->trainerProfile->user->name }}</strong><br>
                                            <small class="text-muted">{{ $wd->trainerProfile->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-danger">Rp {{ number_format($wd->amount, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <span class="d-block fw-bold">{{ $wd->bank_name }}</span>
                                            <span class="d-block">{{ $wd->account_number }}</span>
                                            <span class="d-block small text-muted">a.n {{ $wd->account_name }}</span>
                                        </td>
                                        <td>
                                            @if($wd->status === 'pending')
                                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Transfer</span>
                                            @elseif($wd->status === 'completed')
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($wd->status === 'pending')
                                                <form method="POST" action="{{ route('admin.withdrawals.complete', $wd->id) }}">
                                                    @csrf @method('PUT')
                                                    <button type="button" class="btn btn-sm btn-primary-mylora w-100" data-confirm="Apakah Anda yakin sudah mentransfer uang ke pelatih ini?"><i class="bi bi-check2-all me-1"></i>Tandai Sudah Ditransfer</button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-secondary w-100" disabled>Sudah Diproses</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada permintaan tarik dana.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $withdrawals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
