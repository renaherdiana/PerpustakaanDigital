@extends('layouts.backend.superadmin.app')

@section('content')

<style>
.card-soft{ border:1px solid #f1f1f1; border-radius:10px; }
.bg-soft-user{ background:#f3f1ff; }
.bg-soft-buku{ background:#eef9ff; }
.bg-soft-anggota{ background:#fff6e9; }
.card-soft h6{ color:#666; font-weight:500; }
.card-soft h3{ font-weight:600; }
.card-icon{ font-size:28px; margin-bottom:6px; }
</style>

<div class="header mb-4">
    <h4 class="gradient-text">Hallo {{ auth()->user()->name ?? 'Superadmin' }} 👋</h4>
    <p class="text-muted">Selamat Datang di Sistem Perpustakaan Digital</p>
</div>

<div class="row g-3">

    <div class="col-md-4">
        <div class="card card-soft bg-soft-user shadow-sm">
            <div class="card-body text-center">
                <div class="card-icon">👥</div>
                <h6>Total User</h6>
                <h3>{{ $totalUser }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-soft bg-soft-buku shadow-sm">
            <div class="card-body text-center">
                <div class="card-icon">📚</div>
                <h6>Total Buku</h6>
                <h3>{{ $totalBuku }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-soft bg-soft-anggota shadow-sm">
            <div class="card-body text-center">
                <div class="card-icon">👤</div>
                <h6>Total Anggota</h6>
                <h3>{{ $totalAnggota }}</h3>
            </div>
        </div>
    </div>

</div>
@endsection