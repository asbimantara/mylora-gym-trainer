@extends('layouts.app')
@section('title', 'Kelola Trainer — Admin')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
            <h2 class="fw-bold mb-4">Kelola Trainer</h2>
            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="">
                                <tr><th>Nama</th><th>Spesialisasi</th><th>Lokasi</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($trainers as $tp)
                                <tr>
                                    <td><strong>{{ $tp->user->name }}</strong><br><small class="text-muted">{{ $tp->user->email }}</small></td>
                                    <td>{{ $tp->category->name ?? $tp->specialization }}</td>
                                    <td>{{ $tp->location }}</td>
                                    <td>Rp {{ number_format($tp->price_per_session, 0, ',', '.') }}</td>
                                    <td>
                                        @if($tp->is_approved)
                                            <span class="badge bg-success badge-status">Verified</span>
                                        @else
                                            <span class="badge bg-warning badge-status">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$tp->is_approved)
                                        <form method="POST" action="{{ route('admin.trainer.approve', $tp->id) }}" class="d-inline">@csrf @method('PUT')
                                            <button class="btn btn-sm btn-success"><i class="bi bi-check"></i> Approve</button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ route('admin.trainer.reject', $tp->id) }}" class="d-inline">@csrf @method('PUT')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x"></i> Reject</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $trainers->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
