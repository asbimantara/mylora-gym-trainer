@extends('layouts.app')
@section('title', 'Laporan — Admin')

@push('styles')
<style>
    @media print {
        body { background: #fff; padding: 0; margin: 0; }
        .navbar, .footer-mylora, .btn, .pagination, nav { display: none !important; }
        .container { max-width: 100% !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .py-5 { padding-top: 0 !important; }
        .stat-card { border: 1px solid #ccc; margin-bottom: 15px; page-break-inside: avoid; }
        h2 { font-size: 24pt !important; margin-bottom: 20px !important; text-align: center; }
        table { border-collapse: collapse !important; width: 100% !important; }
        th, td { border: 1px solid #ddd !important; padding: 8px !important; }
        .badge { color: #000 !important; background: transparent !important; border: 1px solid #000 !important; }
    }
</style>
@endpush

@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
                    <h2 class="fw-bold mb-0">Laporan Transaksi Keuangan</h2>
                </div>
                <button onclick="window.print()" class="btn btn-primary-mylora"><i class="bi bi-printer me-2"></i>Cetak PDF</button>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-md-4"><div class="stat-card text-center"><div class="stat-value" style="color:#059669;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div><small class="text-muted">Total Pembayaran Member</small></div></div>
                <div class="col-md-4"><div class="stat-card text-center"><div class="stat-value" style="color:#2563eb;">Rp {{ number_format($platformEarnings, 0, ',', '.') }}</div><small class="text-muted">Keuntungan MyLoRa (10%)</small></div></div>
                <div class="col-md-4"><div class="stat-card text-center"><div class="stat-value" style="color:#d97706;">Rp {{ number_format($trainerEarnings, 0, ',', '.') }}</div><small class="text-muted">Pendapatan Bersih Trainer</small></div></div>
            </div>
            
            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="">
                                <tr><th>Order ID</th><th>Member</th><th>Trainer</th><th>Paket</th><th>Jumlah Dibayar</th><th>Komisi (10%)</th><th>Status</th><th>Tanggal</th></tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $trx)
                                <tr>
                                    <td><small>{{ $trx->midtrans_order_id }}</small></td>
                                    <td>{{ $trx->user->name ?? '-' }}</td>
                                    <td>{{ $trx->packagePurchase->trainerProfile->user->name ?? '-' }}</td>
                                    <td>{{ $trx->packagePurchase->trainerPackage->name ?? '-' }}</td>
                                    <td><strong>Rp {{ number_format($trx->amount, 0, ',', '.') }}</strong></td>
                                    <td class="text-primary"><strong>Rp {{ number_format($trx->platform_fee, 0, ',', '.') }}</strong></td>
                                    <td><span class="badge bg-{{ $trx->status_badge }} badge-status">{{ $trx->status_label }}</span></td>
                                    <td><small>{{ $trx->created_at->format('d M Y H:i') }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
