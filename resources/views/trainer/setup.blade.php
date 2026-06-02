@extends('layouts.app')
@section('title', 'Setup Profil Trainer')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container text-center">
            <i class="bi bi-person-badge text-success" style="font-size:4rem;"></i>
            <h3 class="fw-bold mt-3">Lengkapi Profil Trainer Kamu</h3>
            <p class="text-muted">Kamu perlu melengkapi profil sebelum bisa menerima booking dari member.</p>
            <a href="{{ route('trainer.profile') }}" class="btn btn-primary-mylora btn-lg mt-2">Lengkapi Profil Sekarang</a>
        </div>
    </section>
</div>
@endsection
