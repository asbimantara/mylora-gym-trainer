@extends('layouts.app')
@section('title', 'Cari Personal Trainer')

@section('content')
    <div style="padding-top: 5rem;">
        <!-- Search Header -->
        <section class="py-4" style="background: var(--dark-2); border-bottom:1px solid rgba(255,255,255,0.05);">
            <div class="container">
                <h2 class="fw-bold mb-3">Cari Personal Trainer</h2>
                <form method="GET" action="{{ route('trainers.index') }}">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Pencarian</label>
                            <input type="text" name="search" class="form-control" placeholder="Nama, spesialisasi, gym..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Semua</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                        {{ $cat->icon }} {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Lokasi</label>
                            <input type="text" name="location" class="form-control" placeholder="Contoh: Tahunan"
                                value="{{ request('location') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Urutkan</label>
                            <select name="sort" class="form-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Pengalaman
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary-mylora w-100"><i class="bi bi-search me-1"></i>
                                Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Results -->
        <section class="py-5">
            <div class="container">
                <p class="text-muted mb-4">Menampilkan <strong>{{ $trainers->total() }}</strong> trainer</p>
                @if($trainers->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-search text-muted" style="font-size:3rem;"></i>
                        <h5 class="mt-3 fw-bold">Trainer tidak ditemukan</h5>
                        <p class="text-muted">Coba ubah filter pencarian kamu</p>
                        <a href="{{ route('trainers.index') }}" class="btn btn-outline-mylora">Reset Filter</a>
                    </div>
                @else
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
                                                <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i></span>
                                            @endif
                                        </div>
                                        <p class="text-muted small mt-2 mb-3">{{ Str::limit($profile->bio, 90) }}</p>
                                        <div class="mb-2">
                                            <small class="text-muted"><i class="bi bi-geo-alt text-danger"></i>
                                                {{ $profile->location }}</small>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted"><i class="bi bi-building"></i>
                                                {{ $profile->gym_name }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted"><i class="bi bi-clock"></i> {{ $profile->experience_years }}
                                                tahun pengalaman</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="star-rating me-2">
                                                @php $avg = round($profile->averageRating(), 1); @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $avg ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">{{ number_format($avg, 1) }}
                                                ({{ $profile->totalReviews() }})</small>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="price-tag">
                                                Rp {{ number_format($profile->price_per_session, 0, ',', '.') }}
                                                <small>/sesi</small>
                                            </div>
                                            <a href="{{ route('trainers.show', $profile->id) }}"
                                                class="btn btn-primary-mylora btn-sm">
                                                Detail <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $trainers->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection