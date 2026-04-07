@extends('layouts.backend.admin.app')

@section('content')

@php
    $user = Auth::guard('web')->user(); // Ambil data petugas yang login
    $foto = $user->photo ? asset('storage/'.$user->photo) : 'https://i.pravatar.cc/150';
@endphp

<div class="container mt-4" style="max-width:750px;">
    <div class="card shadow-sm rounded-4 p-4">
        
        <!-- HEADER -->
        <div class="text-center mb-4">
            <img src="{{ $foto }}" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover; border:3px solid #7c6cf3;">
            <h4 class="mb-1">{{ $user->name }}</h4>
            <small class="text-muted">{{ $user->role == 'petugas' ? 'Petugas Perpustakaan' : 'Superadmin' }}</small>
        </div>

        <!-- INFO CARDS -->
        <div class="row g-3">

            <div class="col-md-6">
                <div class="card info-card p-3 h-100 shadow-sm">
                    <h6 class="text-muted">Nama Lengkap</h6>
                    <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card info-card p-3 h-100 shadow-sm">
                    <h6 class="text-muted">Email</h6>
                    <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card info-card p-3 h-100 shadow-sm">
                    <h6 class="text-muted">No. Telepon</h6>
                    <p class="mb-0 fw-semibold">{{ $user->phone ?? '-' }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card info-card p-3 h-100 shadow-sm">
                    <h6 class="text-muted">Status</h6>
                    <p class="mb-0">
                        <span class="badge {{ $user->status == 'aktif' ? 'badge-active' : 'badge-inactive' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </p>
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="text-center mt-4">
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary px-4">✏️ Edit Profil</a>
        </div>

    </div>
</div>

<style>
/* BADGE */
.badge-active { background:#d1fae5; color:#065f46; padding:6px 12px; border-radius:20px; }
.badge-inactive { background:#fee2e2; color:#991b1b; padding:6px 12px; border-radius:20px; }

/* INFO CARD */
.info-card {
    border-radius: 12px;
    border: 1px solid #f1f1f5;
    transition: 0.2s;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
}
</style>

@endsection