@extends('layouts.app')
@section('title', 'Edit Profil Trainer')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('trainer.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4"><i class="bi bi-person-badge me-2"></i>Profil Trainer</h3>
                            <form method="POST" action="{{ route('trainer.profile.update') }}">
                                @csrf @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kategori Spesialisasi</label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ ($profile->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Spesialisasi (Detail)</label>
                                        <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $profile->specialization ?? '') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Bio / Deskripsi</label>
                                        <textarea name="bio" class="form-control" rows="4" required>{{ old('bio', $profile->bio ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Pengalaman (Tahun)</label>
                                        <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $profile->experience_years ?? 0) }}" min="0" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Durasi per Sesi</label>
                                        <select name="session_duration" class="form-select" required>
                                            <option value="30" {{ ($profile->session_duration ?? 60) == 30 ? 'selected' : '' }}>30 Menit</option>
                                            <option value="45" {{ ($profile->session_duration ?? 60) == 45 ? 'selected' : '' }}>45 Menit</option>
                                            <option value="60" {{ ($profile->session_duration ?? 60) == 60 ? 'selected' : '' }}>60 Menit (1 Jam)</option>
                                            <option value="90" {{ ($profile->session_duration ?? 60) == 90 ? 'selected' : '' }}>90 Menit (1.5 Jam)</option>
                                            <option value="120" {{ ($profile->session_duration ?? 60) == 120 ? 'selected' : '' }}>120 Menit (2 Jam)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Harga per Sesi (Rp)</label>
                                        <input type="number" name="price_per_session" class="form-control" value="{{ old('price_per_session', $profile->price_per_session ?? 0) }}" min="0" required>
                                        <small class="text-muted">Untuk referensi paket</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Telepon</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Lokasi</label>
                                        <input type="text" name="location" class="form-control" value="{{ old('location', $profile->location ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nama Gym</label>
                                        <input type="text" name="gym_name" class="form-control" value="{{ old('gym_name', $profile->gym_name ?? '') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Sertifikasi (pisahkan dengan koma)</label>
                                        <input type="text" name="certifications" class="form-control" value="{{ old('certifications', $profile->certifications ?? '') }}" placeholder="ACE CPT, NASM, dll.">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary-mylora mt-4">Simpan Profil</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
