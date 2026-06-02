@extends('layouts.app')
@section('title', $profile->user->name . ' — Trainer MyLoRa')

@section('content')
    <div style="padding-top: 5rem;">
        <section class="py-5">
            <div class="container">
                <a href="{{ route('trainers.index') }}" class="btn btn-sm btn-outline-secondary mb-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm" style="border-radius:1rem; overflow:hidden;">
                            <div class="trainer-avatar" style="height:280px; font-size:6rem;">
                                @if($profile->user->avatar)
                                    <img src="{{ asset('images/avatars/' . $profile->user->avatar) }}"
                                        alt="{{ $profile->user->name }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    {{ $profile->category->icon ?? '💪' }}
                                @endif
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h2 class="fw-bold mb-1">{{ $profile->user->name }}</h2>
                                        <span
                                            class="badge-category">{{ $profile->category->name ?? $profile->specialization }}</span>
                                        @if($profile->is_approved)
                                            <span class="badge bg-success ms-2"><i
                                                    class="bi bi-patch-check-fill me-1"></i>Verified</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="star-rating me-2">
                                        @php $avg = round($profile->averageRating(), 1); @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $avg ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="fw-semibold">{{ number_format($avg, 1) }}</span>
                                    <small class="text-muted ms-1">({{ $profile->totalReviews() }} ulasan)</small>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">
                                            <small class="text-muted d-block">Pengalaman</small>
                                            <strong>{{ $profile->experience_years }} Tahun</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">
                                            <small class="text-muted d-block">Durasi Sesi</small>
                                            <strong>{{ $profile->session_duration_hours }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">
                                            <small class="text-muted d-block">Lokasi</small>
                                            <strong>{{ $profile->location }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);">
                                            <small class="text-muted d-block">Gym</small>
                                            <strong>{{ $profile->gym_name }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="fw-bold mb-2">Tentang</h5>
                                <p class="text-muted">{{ $profile->bio }}</p>

                                @if($profile->certifications)
                                    <h5 class="fw-bold mb-2 mt-4">Sertifikasi</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(explode(',', $profile->certifications) as $cert)
                                            <span class="badge bg-warning-subtle text-warning-emphasis border px-3 py-2"><i
                                                    class="bi bi-award me-1 text-warning"></i>{{ trim($cert) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Packages -->
                                <h5 class="fw-bold mb-3 mt-4">Paket Latihan</h5>
                                <div class="row g-3">
                                    @foreach($profile->packages as $pkg)
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3 h-100 {{ $pkg->session_count >= 12 ? 'border-success' : '' }}"
                                                style="transition:all 0.3s;"
                                                onmouseover="this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)'"
                                                onmouseout="this.style.boxShadow=''">
                                                @if($pkg->session_count >= 12)
                                                    <span class="badge bg-success mb-2">🔥 Best Value</span>
                                                @endif
                                                <h6 class="fw-bold mb-1">{{ $pkg->name }}</h6>
                                                <div class="price-tag mb-1">
                                                    Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                                </div>
                                                <small class="text-muted">{{ $pkg->session_count }} sesi × Rp
                                                    {{ number_format($pkg->price_per_session, 0, ',', '.') }}/sesi</small>
                                                @if($pkg->discount_percent > 0)
                                                    <span class="badge bg-danger ms-1">Hemat {{ $pkg->discount_percent }}%</span>
                                                @endif
                                                @if($pkg->description)
                                                    <p class="text-muted small mt-2 mb-2">{{ $pkg->description }}</p>
                                                @endif
                                                @if($pkg->benefits)
                                                    <div class="mt-2">
                                                        @foreach($pkg->benefits_array as $benefit)
                                                            <div class="small"><i
                                                                    class="bi bi-check-circle-fill text-success me-1"></i>{{ $benefit }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Jadwal Kerja -->
                                <h5 class="fw-bold mb-3 mt-4">Jam Kerja</h5>
                                @if($profile->availabilities->isEmpty())
                                    <p class="text-muted">Belum ada jadwal tersedia.</p>
                                @else
                                    @foreach($profile->availabilities as $avail)
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <span class="fw-semibold">{{ $avail->day_name }}</span>
                                            <span class="badge bg-secondary-subtle text-body border">{{ substr($avail->start_hour, 0, 5) }} -
                                                {{ substr($avail->end_hour, 0, 5) }}</span>
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Reviews -->
                                <h5 class="fw-bold mb-3 mt-4">Ulasan ({{ $profile->totalReviews() }})</h5>
                                @forelse($profile->reviews as $review)
                                    <div class="border rounded-3 p-3 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $review->user->name }}</strong>
                                            <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                                        </div>
                                        <div class="star-rating my-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"
                                                    style="font-size:0.85rem;"></i>
                                            @endfor
                                        </div>
                                        @if($review->comment)
                                        <p class="mb-0 text-muted small">{{ $review->comment }}</p>@endif
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada ulasan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm sticky-top" style="border-radius:1rem; top:6rem;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Mulai
                                    Latihan</h5>
                                <p class="text-muted small mb-3">Pilih paket, bayar, lalu atur jadwal sesi fleksibel sesuai
                                    waktumu.</p>

                                <div class="text-center mb-3">
                                    <small class="text-muted">Mulai dari</small>
                                    <div class="price-tag" style="font-size:1.5rem;">
                                        Rp {{ number_format($profile->packages->min('price'), 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted">per
                                        {{ $profile->packages->sortBy('price')->first()->session_count ?? 1 }} sesi</small>
                                </div>

                                <div class="alert alert-warning small py-2 mb-3" style="border-radius:0.5rem;">
                                    <i class="bi bi-info-circle me-1"></i> <strong>Catatan:</strong> Harga paket di atas
                                    belum termasuk biaya member/visit Gym.
                                </div>

                                @auth
                                    @if(auth()->user()->isMember())
                                        <a href="{{ route('bookings.select-package', $profile->id) }}"
                                            class="btn btn-primary-mylora w-100 btn-lg">
                                            <i class="bi bi-bag-check me-2"></i>Pilih Paket & Booking
                                        </a>
                                    @elseif(auth()->user()->isTrainer())
                                        <div class="alert alert-info small mb-0">
                                            <i class="bi bi-info-circle me-1"></i>Hanya Member yang bisa booking.
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary-mylora w-100 btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Booking
                                    </a>
                                    <p class="text-center mt-2 small text-muted">Belum punya akun? <a
                                            href="{{ route('register') }}">Daftar gratis</a></p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection