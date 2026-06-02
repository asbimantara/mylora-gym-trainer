@extends('layouts.app')
@section('title', 'Paket Latihan')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <a href="{{ route('trainer.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4"><i class="bi bi-box-seam me-2 text-success"></i>Tambah Paket Latihan</h3>
                            <form method="POST" action="{{ route('trainer.packages.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nama Paket</label>
                                        <input type="text" name="name" class="form-control" placeholder="Contoh: Paket 8 Sesi" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jumlah Sesi</label>
                                        <input type="number" name="session_count" class="form-control" min="1" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Total Harga (Rp)</label>
                                        <input type="number" name="price" class="form-control" min="0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Deskripsi Singkat (Opsional)</label>
                                        <textarea name="description" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Benefit (Pisahkan dengan koma)</label>
                                        <textarea name="benefits" class="form-control" rows="2" placeholder="Diet plan, Pemantauan body fat..."></textarea>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary-mylora">Simpan Paket</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">Paket Saat Ini</h5>
                    @if($packages->isEmpty())
                        <p class="text-muted">Belum ada paket latihan.</p>
                    @else
                    <div class="row g-3">
                        @foreach($packages as $pkg)
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100 position-relative">
                                <form method="POST" action="{{ route('trainer.packages.delete', $pkg->id) }}" class="position-absolute" style="top:10px; right:10px;">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger border-0" data-confirm="Hapus paket ini secara permanen?"><i class="bi bi-trash"></i></button>
                                </form>
                                <h6 class="fw-bold mb-1">{{ $pkg->name }}</h6>
                                <span class="badge bg-secondary-subtle text-body border mb-2">{{ $pkg->session_count }} Sesi</span>
                                <div class="price-tag mb-2">Rp {{ number_format($pkg->price, 0, ',', '.') }}</div>
                                <small class="text-muted">Rp {{ number_format($pkg->price_per_session, 0, ',', '.') }}/sesi</small>
                                @if($pkg->description)
                                <p class="text-muted small mt-2 mb-0">{{ $pkg->description }}</p>
                                @endif
                            </div>
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
