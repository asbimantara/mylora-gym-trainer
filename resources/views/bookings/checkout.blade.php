@extends('layouts.app')
@section('title', 'Checkout Pembayaran')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4"><i class="bi bi-credit-card me-2 text-success"></i>Checkout</h3>
                            <div class="p-3 rounded-3 mb-4" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">
                                <h6 class="fw-bold mb-3">Ringkasan Pembelian Paket</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Trainer</span>
                                    <strong>{{ $purchase->trainerProfile->user->name }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Paket</span>
                                    <strong>{{ $purchase->trainerPackage->name }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Jumlah Sesi</span>
                                    <span>{{ $purchase->sessions_total }} sesi</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Spesialisasi</span>
                                    <span>{{ $purchase->trainerProfile->category->name ?? '-' }}</span>
                                </div>
                            </div>
                            @if($purchase->transaction)
                            <div class="p-3 rounded-3 mb-4" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-left:4px solid #10b981;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Harga Paket</span>
                                    <span>Rp {{ number_format($purchase->transaction->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">Biaya Platform (10%)</span>
                                    <span class="small text-muted">Rp {{ number_format($purchase->transaction->platform_fee, 0, ',', '.') }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    @php $totalPay = $purchase->transaction->amount + $purchase->transaction->platform_fee; @endphp
                                    <strong class="price-tag text-success" style="font-size:1.3rem;">Rp {{ number_format($totalPay, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <small class="text-muted">Order ID: {{ $purchase->transaction->midtrans_order_id }}</small>
                            </div>
                            @if($purchase->transaction->status === 'pending')
                            @if(isset($snapToken))
                                <div class="p-3 mb-3 rounded-3 border text-center">
                                    <i class="bi bi-shield-check text-success" style="font-size:2rem;"></i>
                                    <p class="small text-muted mt-2 mb-0">Pembayaran aman via <strong>Midtrans Sandbox</strong></p>
                                </div>
                                <button id="pay-button" class="btn btn-primary-mylora btn-lg w-100">
                                    <i class="bi bi-shield-check me-2"></i>Bayar Sekarang — Rp {{ number_format($purchase->transaction->amount + $purchase->transaction->platform_fee, 0, ',', '.') }}
                                </button>

                                <form id="payment-success-form" method="POST" action="{{ route('bookings.pay', $purchase->id) }}" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <div class="alert alert-danger text-center">
                                    Gagal terhubung ke Midtrans. Pastikan Server Key Sandbox sudah diatur di .env
                                </div>
                            @endif
                            @elseif($purchase->transaction->status === 'success')
                            <div class="alert alert-success text-center">
                                <i class="bi bi-check-circle-fill me-2"></i>Pembayaran berhasil! Silakan booking sesi.
                            </div>
                            <a href="{{ route('bookings.book-session', $purchase->id) }}" class="btn btn-primary-mylora w-100">Booking Sesi Pertama</a>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@if(isset($snapToken))
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                document.getElementById('payment-success-form').submit();
            },
            onPending: function(result){
                alert("Menunggu pembayaran!"); console.log(result);
            },
            onError: function(result){
                alert("Pembayaran gagal!"); console.log(result);
            },
            onClose: function(){
                // user closed the popup
            }
        });
    };
</script>
@endpush
@endif
