@extends('layouts.app')
@section('title', 'MyLoRa Gym Trainer — Temukan Personal Trainer Terbaik di Jepara')

@section('content')
    <!-- Hero Section -->
    <section class="text-white"
        style="background: linear-gradient(rgba(18, 18, 18, 0.85), rgba(18, 18, 18, 0.95)), url('{{ asset('images/gym-hero.png') }}') center/cover no-repeat; padding: 10rem 0 6rem; border-bottom: 2px solid var(--primary);">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge text-dark px-3 py-2 mb-3" style="background: var(--primary); font-size:0.85rem;">
                        Platform Fitness #1 di Jepara
                    </span>
                    <h1 class="display-4 fw-bold mb-3" style="line-height:1.15;">
                        Temukan <span style="color: var(--primary);">Personal Trainer</span><br>
                        Terbaik di Jepara
                    </h1>
                    <p class="lead mb-4" style="color: rgba(255,255,255,0.7); max-width: 500px;">
                        MyLoRa menghubungkan kamu dengan trainer fitness profesional dan tersertifikasi di area Jepara.
                        Booking mudah, bayar aman.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('trainers.index') }}" class="btn btn-primary-mylora btn-lg px-4">
                            <i class="bi bi-search me-2"></i>Cari Trainer Sekarang
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4"
                                style="border-radius:0.75rem;">
                                Daftar Gratis <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @endguest
                    </div>
                    <div class="d-flex gap-4 mt-4 pt-2">
                        <div>
                            <div class="fw-bold fs-4">{{ $trainerCount }}+</div>
                            <small style="color:rgba(255,255,255,0.5);">Trainer Aktif</small>
                        </div>
                        <div>
                            <div class="fw-bold fs-4">{{ $categoryCount }}</div>
                            <small style="color:rgba(255,255,255,0.5);">Spesialisasi</small>
                        </div>
                        <div>
                            <div class="fw-bold fs-4">10+</div>
                            <small style="color:rgba(255,255,255,0.5);">Gym Partner</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <!-- Hero space -->
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5" style="margin-top: -2rem;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card text-center p-4 h-100"
                        style="background: var(--dark-2); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="stat-icon mx-auto mb-3" style="background: rgba(204,255,0,0.1); color: var(--primary);">
                            <i class="bi bi-search"></i>
                        </div>
                        <h5 class="fw-bold text-white">1. Cari Trainer</h5>
                        <p class="text-muted small mb-0">Filter berdasarkan spesialisasi, lokasi, harga, dan jadwal yang
                            sesuai kebutuhanmu.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center p-4 h-100"
                        style="background: var(--dark-2); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="stat-icon mx-auto mb-3" style="background: rgba(204,255,0,0.1); color: var(--primary);">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h5 class="fw-bold text-white">2. Booking Jadwal</h5>
                        <p class="text-muted small mb-0">Pilih jadwal yang tersedia dan lakukan reservasi langsung melalui
                            platform.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center p-4 h-100"
                        style="background: var(--dark-2); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="stat-icon mx-auto mb-3" style="background: rgba(204,255,0,0.1); color: var(--primary);">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h5 class="fw-bold text-white">3. Bayar & Latihan</h5>
                        <p class="text-muted small mb-0">Bayar aman via Midtrans, lalu mulai sesi latihan bersama trainer
                            pilihanmu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Trainers -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Trainer Unggulan Kami</h2>
                <p class="section-subtitle mx-auto">Personal trainer profesional dan tersertifikasi yang siap membantu kamu
                    mencapai goals fitness</p>
            </div>
            <div class="row g-4">
                @foreach($trainers as $profile)
                    <div class="col-md-4">
                        <div class="card card-trainer h-100">
                            <div class="trainer-avatar">
                                @if($profile->user->avatar)
                                    <img src="{{ asset('images/avatars/' . $profile->user->avatar) }}"
                                        alt="{{ $profile->user->name }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    {{ $profile->category->icon ?? '💪' }}
                                @endif
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $profile->user->name }}</h5>
                                        <span
                                            class="badge-category">{{ $profile->category->name ?? $profile->specialization }}</span>
                                    </div>
                                    @if($profile->is_approved)
                                        <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verified</span>
                                    @endif
                                </div>
                                <p class="text-muted small mt-2 mb-3">{{ Str::limit($profile->bio, 100) }}</p>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <small class="text-muted"><i class="bi bi-geo-alt text-danger"></i>
                                        {{ $profile->location }}</small>
                                    <small class="text-muted"><i class="bi bi-building"></i> {{ $profile->gym_name }}</small>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="star-rating me-2">
                                        @php $avg = round($profile->averageRating(), 1); @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $avg ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">({{ $profile->totalReviews() }} ulasan)</small>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="price-tag">
                                        Rp {{ number_format($profile->price_per_session, 0, ',', '.') }}
                                        <small>/sesi</small>
                                    </div>
                                    <a href="{{ route('trainers.show', $profile->id) }}" class="btn btn-primary-mylora btn-sm">
                                        Lihat Profil <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('trainers.index') }}" class="btn btn-outline-mylora btn-lg">
                    Lihat Semua Trainer <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-5" style="background: var(--dark);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Kategori Spesialisasi</h2>
                <p class="section-subtitle mx-auto">Pilih jenis latihan sesuai kebutuhan dan goals fitness kamu</p>
            </div>
            <div class="row g-3">
                @foreach($categories as $cat)
                    <div class="col-md-4 col-6">
                        <a href="{{ route('trainers.index', ['category' => $cat->slug]) }}" class="text-decoration-none">
                            <div class="stat-card text-center p-4 h-100" style="transition:all 0.3s; cursor:pointer;"
                                onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 30px rgba(0,0,0,0.08)'"
                                onmouseout="this.style.transform='';this.style.boxShadow=''">
                                <div style="font-size: 2.5rem;">{{ $cat->icon }}</div>
                                <h6 class="fw-bold mt-2 mb-1 text-white">{{ $cat->name }}</h6>
                                <small class="text-muted">{{ $cat->description }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 text-white" style="background: var(--dark-2); border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container text-center position-relative py-4">
            <h2 class="fw-bold mb-3">Siap Mulai Perjalanan Fitness Kamu?</h2>
            <p class="mb-4" style="color:rgba(255,255,255,0.7); max-width:500px; margin:0 auto;">Daftar sekarang dan temukan
                personal trainer yang tepat untuk bantu kamu mencapai body goals.</p>
            <div class="d-flex gap-3 justify-content-center">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary-mylora btn-lg px-4">Daftar Sebagai Member</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4"
                        style="border-radius:0.75rem;">Daftar Sebagai Trainer</a>
                @else
                    <a href="{{ route('trainers.index') }}" class="btn btn-primary-mylora btn-lg px-4">Cari Trainer</a>
                @endguest
            </div>
        </div>
    </section>
@endsection