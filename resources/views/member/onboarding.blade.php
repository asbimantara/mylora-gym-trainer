@extends('layouts.app')
@section('title', 'Mulai Perjalanan Anda')

@section('content')
<div style="padding-top: 5rem; min-height: 100vh;">
    <section class="py-5">
        <div class="container" style="max-width: 600px;">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Selamat Datang di MyLoRa! 🎉</h2>
                <p class="text-muted">Sebelum mulai, mari bantu kami memahami kebutuhan Anda agar kami bisa memberikan rekomendasi pelatih terbaik.</p>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('member.onboarding.process') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Apa tujuan utama Anda nge-gym?</label>
                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="goal" id="goal1" value="fat_loss" checked>
                                    <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="goal1">
                                        <i class="bi bi-fire d-block mb-2 text-primary fs-4"></i>
                                        <span class="fw-bold d-block">Fat Loss</span>
                                        <small class="text-muted">Membakar lemak & menurunkan berat badan.</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="goal" id="goal2" value="muscle_gain">
                                    <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="goal2">
                                        <i class="bi bi-person-arms-up d-block mb-2 text-primary fs-4"></i>
                                        <span class="fw-bold d-block">Muscle Gain</span>
                                        <small class="text-muted">Membangun massa otot & kekuatan.</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="goal" id="goal3" value="flexibility">
                                    <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="goal3">
                                        <i class="bi bi-yin-yang d-block mb-2 text-primary fs-4"></i>
                                        <span class="fw-bold d-block">Flexibility</span>
                                        <small class="text-muted">Kelenturan & keseimbangan tubuh.</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="goal" id="goal4" value="stamina">
                                    <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="goal4">
                                        <i class="bi bi-heart-pulse d-block mb-2 text-primary fs-4"></i>
                                        <span class="fw-bold d-block">Stamina & Health</span>
                                        <small class="text-muted">Kebugaran jantung & fungsional.</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold">Seberapa sering Anda berolahraga?</label>
                            <select name="level" class="form-select form-select-lg" required>
                                <option value="" selected disabled>Pilih tingkat pengalaman...</option>
                                <option value="beginner">Pemula (Jarang berolahraga)</option>
                                <option value="intermediate">Menengah (1-2 kali seminggu)</option>
                                <option value="advanced">Lanjutan (Lebih dari 3 kali seminggu)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-mylora btn-lg">Lihat Rekomendasi Pelatih</button>
                            <a href="{{ route('member.dashboard') }}" class="btn btn-link text-muted">Lewati, saya ingin pilih sendiri</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.btn-outline-primary {
    border-color: rgba(255,255,255,0.2);
    color: var(--bs-body-color);
}
.btn-outline-primary:hover {
    border-color: #c4f000;
    background-color: rgba(196, 240, 0, 0.05);
    color: #c4f000;
}
.btn-check:checked + .btn-outline-primary {
    border-color: #c4f000;
    background-color: rgba(196, 240, 0, 0.1);
    color: #c4f000;
    box-shadow: 0 0 0 0.25rem rgba(196, 240, 0, 0.25);
}
.btn-check:checked + .btn-outline-primary .text-muted {
    color: rgba(255,255,255,0.8) !important;
}
</style>
@endsection
