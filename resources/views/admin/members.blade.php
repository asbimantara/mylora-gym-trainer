@extends('layouts.app')
@section('title', 'Kelola Member — Admin')
@section('content')
<div style="padding-top: 5rem;">
    <section class="py-5">
        <div class="container">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
            <h2 class="fw-bold mb-4">Kelola Member</h2>
            <div class="card border-0 shadow-sm" style="border-radius:1rem;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="">
                                <tr><th>Nama & Email</th><th>No. HP</th><th>Bergabung Sejak</th><th>Total Paket Dibeli</th><th>Total Sesi Booking</th></tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td><strong>{{ $member->name }}</strong><br><small class="text-muted">{{ $member->email }}</small></td>
                                    <td>{{ $member->phone ?? '-' }}</td>
                                    <td>{{ $member->created_at->format('d M Y') }}</td>
                                    <td><span class="badge bg-primary rounded-pill">{{ $member->package_purchases_count }} Paket</span></td>
                                    <td><span class="badge bg-success rounded-pill">{{ $member->bookings_count }} Sesi</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
