@extends('layouts.app')
@section('title', 'Jam Kerja')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('trainer.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-1"><i class="bi bi-clock me-2 text-success"></i>Atur Jam Kerja</h3>
                            <p class="text-muted small mb-4">Member dapat memilih slot waktu secara fleksibel selama jam kerja yang kamu tentukan.</p>
                            <form method="POST" action="{{ route('trainer.availability.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Hari</label>
                                        <select name="day_of_week" class="form-select" required>
                                            <option value="1">Senin</option>
                                            <option value="2">Selasa</option>
                                            <option value="3">Rabu</option>
                                            <option value="4">Kamis</option>
                                            <option value="5">Jumat</option>
                                            <option value="6">Sabtu</option>
                                            <option value="0">Minggu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Jam Buka</label>
                                        <input type="time" name="start_hour" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Jam Tutup</label>
                                        <input type="time" name="end_hour" class="form-control" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary-mylora w-100">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Jam Kerja Saat Ini</h5>
                            @if($availabilities->isEmpty())
                                <p class="text-muted">Belum ada jam kerja yang diatur.</p>
                            @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class=""><tr><th>Hari</th><th>Jam Buka</th><th>Jam Tutup</th><th>Status</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        @foreach($availabilities as $avail)
                                        <tr>
                                            <td><strong>{{ $avail->day_name }}</strong></td>
                                            <td>{{ substr($avail->start_hour, 0, 5) }}</td>
                                            <td>{{ substr($avail->end_hour, 0, 5) }}</td>
                                            <td><span class="badge bg-{{ $avail->is_available ? 'success' : 'secondary' }}">{{ $avail->is_available ? 'Tersedia' : 'Tutup' }}</span></td>
                                            <td>
                                                <form method="POST" action="{{ route('trainer.availability.delete', $avail->id) }}">@csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
