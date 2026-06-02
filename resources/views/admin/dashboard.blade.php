@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Dashboard Admin</h2>
                <div>
                    <a href="{{ route('admin.payouts') }}" class="btn btn-primary-mylora btn-sm me-2"><i class="bi bi-shield-check me-1"></i>Verifikasi Payout</a>
                    <a href="{{ route('admin.trainers') }}" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-people me-1"></i>Kelola Trainer</a>
                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-graph-up me-1"></i>Laporan</a>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-5">
                <div class="col-md-2 col-6"><div class="stat-card text-center"><div class="stat-value text-primary">{{ $totalMembers }}</div><small class="text-muted">Member</small></div></div>
                <div class="col-md-2 col-6"><div class="stat-card text-center"><div class="stat-value text-success">{{ $totalTrainers }}</div><small class="text-muted">Trainer</small></div></div>
                <div class="col-md-2 col-6"><div class="stat-card text-center"><div class="stat-value text-warning">{{ $pendingTrainers }}</div><small class="text-muted">Pending</small></div></div>
                <div class="col-md-2 col-6"><div class="stat-card text-center"><div class="stat-value text-info">{{ $totalTransactions }}</div><small class="text-muted">Transaksi</small></div></div>
                <div class="col-md-2 col-6"><div class="stat-card text-center"><div class="stat-value" style="font-size:1.1rem; color:#059669;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div><small class="text-muted">Total Revenue</small></div></div>
                <div class="col-md-2 col-6"><div class="stat-card text-center"><div class="stat-value" style="font-size:1.1rem; color:#2563eb;">Rp {{ number_format($platformEarnings, 0, ',', '.') }}</div><small class="text-muted">Earning Platform</small></div></div>
            </div>

            <!-- Recent Purchases -->
            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Pembelian Paket Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class=""><tr><th>Member</th><th>Trainer</th><th>Paket</th><th>Total Pembayaran</th><th>Status Pembayaran</th></tr></thead>
                            <tbody>
                                @foreach($recentPurchases as $purchase)
                                <tr>
                                    <td><strong>{{ $purchase->user->name }}</strong></td>
                                    <td>{{ $purchase->trainerProfile->user->name ?? '-' }}</td>
                                    <td>{{ $purchase->trainerPackage->name ?? '-' }} ({{ $purchase->sessions_total }} sesi)</td>
                                    <td>Rp {{ number_format($purchase->transaction->amount ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @if($purchase->transaction)
                                        <span class="badge bg-{{ $purchase->transaction->status_badge }}">{{ $purchase->transaction->status_label }}</span>
                                        @else
                                        <span class="badge bg-secondary">Tidak ada transaksi</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
