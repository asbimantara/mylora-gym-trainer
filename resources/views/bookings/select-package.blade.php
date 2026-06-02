@extends('layouts.app')
@section('title', 'Pilih Paket — ' . $profile->user->name)
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <a href="{{ route('trainers.show', $profile->id) }}" class="btn btn-sm btn-outline-secondary mb-4"><i class="bi bi-arrow-left me-1"></i> Kembali</a>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Pilih Paket Latihan</h2>
                        <p class="text-muted">{{ $profile->user->name }} • {{ $profile->specialization }} • {{ $profile->session_duration_hours }}/sesi</p>
                        <div class="alert alert-warning small py-2 d-inline-block mx-auto mt-2" style="border-radius:0.5rem;">
                            <i class="bi bi-info-circle me-1"></i> <strong>Catatan:</strong> Harga paket belum termasuk biaya member/visit Gym.
                        </div>
                    </div>

                    @if($profile->packages->isEmpty())
                        <div class="text-center py-5"><p class="text-muted">Trainer belum memiliki paket.</p></div>
                    @else
                    <div class="row g-4 justify-content-center">
                        @foreach($profile->packages as $pkg)
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('bookings.checkout', $profile->id) }}">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $pkg->id }}">
                                <div class="card border-0 shadow-sm h-100 {{ $pkg->session_count >= 12 ? 'border-2 border-success' : '' }}" style="border-radius:1rem; transition:all 0.3s; cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 15px 35px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                                    <div class="card-body p-4 text-center">
                                        @if($pkg->session_count >= 12)
                                        <span class="badge bg-success mb-2">🔥 Best Value</span>
                                        @endif
                                        <h4 class="fw-bold mb-1">{{ $pkg->name }}</h4>
                                        <div class="mb-2">
                                            <span class="badge bg-secondary-subtle text-body border">{{ $pkg->session_count }} sesi</span>
                                        </div>
                                        <div class="price-tag my-3" style="font-size:1.8rem;">
                                            Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                        </div>
                                        <p class="text-muted small">
                                            Rp {{ number_format($pkg->price_per_session, 0, ',', '.') }} / sesi
                                            @if($pkg->discount_percent > 0)
                                            <br><span class="text-danger fw-semibold">Hemat {{ $pkg->discount_percent }}%</span>
                                            @endif
                                        </p>
                                        @if($pkg->description)
                                        <p class="text-muted small">{{ $pkg->description }}</p>
                                        @endif
                                        <hr>
                                        @if($pkg->benefits)
                                        <div class="text-start mb-3">
                                            @foreach($pkg->benefits_array as $benefit)
                                            <div class="small mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $benefit }}</div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <button type="submit" class="btn {{ $pkg->session_count >= 12 ? 'btn-primary-mylora' : 'btn-outline-mylora' }} w-100">
                                            Pilih Paket <i class="bi bi-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
