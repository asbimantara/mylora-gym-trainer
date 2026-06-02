@extends('layouts.app')
@section('title', 'Rekomendasi Pelatih')

@section('content')
<div style="padding-top: 5rem; min-height: 100vh;">
    <section class="py-5">
        <div class="container" style="max-width: 800px;">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Rekomendasi Spesial Untuk Anda 🎯</h2>
                <p class="text-muted">Berdasarkan tujuan <strong>{{ str_replace('_', ' ', strtoupper($goal)) }}</strong> Anda, sistem kami menemukan pelatih yang paling cocok!</p>
            </div>

            @if($trainer)
            <div class="card border-0 shadow-lg mb-5" style="border-radius:1rem; overflow:hidden;">
                <div class="row g-0">
                    <div class="col-md-5" style="background-image: url('{{ $trainer->user->avatar ? asset('images/avatars/' . $trainer->user->avatar) : asset('images/default-avatar.png') }}'); background-size: cover; background-position: top; min-height:300px; border-right: 1px solid rgba(255,255,255,0.05);">
                        @if(!$trainer->user->avatar)
                        <div class="h-100 d-flex align-items-center justify-content-center" style="background-color: rgba(255,255,255,0.02);">
                            <i class="bi bi-person text-secondary" style="font-size: 5rem;"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4 p-md-5">
                            <span class="badge bg-primary mb-2">Match 98%</span>
                            <h3 class="fw-bold">{{ $trainer->user->name }}</h3>
                            <p class="text-muted mb-4"><i class="bi bi-tags me-2"></i>Spesialisasi: <strong>{{ $trainer->category->name ?? 'General Training' }}</strong></p>
                            
                            <div class="mb-4">
                                <h6 class="fw-bold">Mengapa Cocok?</h6>
                                <p class="text-muted small">Pelatih ini memiliki rekam jejak luar biasa dalam membantu klien mencapai tujuan {{ str_replace('_', ' ', strtolower($goal)) }}. Metode latihannya sangat direkomendasikan untuk pengalaman Anda.</p>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('trainers.show', $trainer->id) }}" class="btn btn-primary-mylora btn-lg">Lihat Profil & Beli Paket</a>
                                <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary" style="border-color: rgba(255,255,255,0.2); color: #fff;">Nanti Saja (Ke Dashboard)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning text-center p-5 shadow-sm" style="border-radius:1rem;">
                <h4>Maaf, belum ada pelatih yang cocok.</h4>
                <p>Silakan telusuri semua pelatih kami.</p>
                <a href="{{ route('trainers.index') }}" class="btn btn-primary-mylora">Cari Pelatih</a>
            </div>
            @endif

            <div class="text-center">
                <a href="{{ route('trainers.index') }}" class="text-muted text-decoration-none">Atau telusuri pelatih lainnya <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </section>
</div>
@endsection
