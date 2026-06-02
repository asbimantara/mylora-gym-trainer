@extends('layouts.app')
@section('title', 'Masuk')
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
                                <p class="text-muted">Masuk ke akun kamu</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Ingat saya</label>
                                </div>
                                <button type="submit" class="btn btn-primary-mylora w-100 btn-lg">Masuk</button>
                            </form>

                            <div class="text-center mt-3">
                                <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-success">Daftar gratis</a></small>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
