@extends('layouts.app')
@section('title', 'Daftar Akun')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold"><i class="bi bi-heart-pulse-fill text-success me-2"></i>MyLoRa</h3>
                                <p class="text-muted">Buat akun baru</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Daftar Sebagai</label>
                                    <select name="role" class="form-select" required>
                                        <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>👤 Member (Mencari Trainer)</option>
                                        <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>🏋️ Trainer (Menawarkan Jasa)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary-mylora w-100 btn-lg">Daftar</button>
                            </form>

                            <div class="text-center mt-3">
                                <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-success">Masuk</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
