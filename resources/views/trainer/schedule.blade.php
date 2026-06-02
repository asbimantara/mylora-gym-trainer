@extends('layouts.app')
@section('title', 'Kelola Jadwal')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('trainer.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4"><i class="bi bi-calendar3 me-2"></i>Tambah Jadwal</h3>
                            <form method="POST" action="{{ route('trainer.schedule.store') }}">
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
                                        <label class="form-label fw-semibold">Jam Mulai</label>
                                        <input type="time" name="start_time" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Jam Selesai</label>
                                        <input type="time" name="end_time" class="form-control" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary-mylora w-100">Tambah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Jadwal Saat Ini</h5>
                            @if($schedules->isEmpty())
                                <p class="text-muted">Belum ada jadwal.</p>
                            @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class=""><tr><th>Hari</th><th>Waktu</th><th>Status</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        @foreach($schedules as $schedule)
                                        <tr>
                                            <td><strong>{{ $schedule->day_name }}</strong></td>
                                            <td>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                                            <td><span class="badge bg-{{ $schedule->is_available ? 'success' : 'secondary' }}">{{ $schedule->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</span></td>
                                            <td>
                                                <form method="POST" action="{{ route('trainer.schedule.delete', $schedule->id) }}">@csrf @method('DELETE')
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
