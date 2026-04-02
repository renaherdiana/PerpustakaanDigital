@extends('layouts.backend.admin.app')

@section('content')

<style>

/* CARD STYLE SOFT */
.card-soft{
    border:1px solid #f1f1f1;
    border-radius:10px;
}

.bg-soft-anggota{
    background:#f3f1ff;
}

.bg-soft-buku{
    background:#eef9ff;
}

.bg-soft-pinjam{
    background:#fff6e9;
}

.bg-soft-denda{
    background:#ffecec;
}

.card-soft h6{
    color:#666;
    font-weight:500;
}

.card-soft h3{
    font-weight:600;
}

/* ICON */
.card-icon{
    font-size:24px;
    margin-bottom:6px;
}

</style>


<div class="header mb-4">
    <h4 class="gradient-text">Hallo Rena Herdiana 👋</h4>
    <p class="text-muted">Selamat Datang di Sistem Perpustakaan Digital</p>
</div>


<div class="row g-3">

<div class="col-md-3">
    <div class="card card-soft bg-soft-anggota shadow-sm">
        <div class="card-body text-center">
            <div class="card-icon">👥</div>
            <h6>Total Anggota</h6>
            <h3>25</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-soft bg-soft-buku shadow-sm">
        <div class="card-body text-center">
            <div class="card-icon">📚</div>
            <h6>Total Buku</h6>
            <h3>120</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-soft bg-soft-pinjam shadow-sm">
        <div class="card-body text-center">
            <div class="card-icon">📖</div>
            <h6>Buku Dipinjam</h6>
            <h3>32</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-soft bg-soft-denda shadow-sm">
        <div class="card-body text-center">
            <div class="card-icon">💰</div>
            <h6>Total Denda</h6>
            <h3>10</h3>
        </div>
    </div>
</div>

</div>


<div class="card mt-4 shadow-sm card-soft">
<div class="card-body">

<h5>Grafik Peminjaman</h5>

<img src="https://dummyimage.com/800x300/eeeeee/000000&text=Grafik+Peminjaman" class="img-fluid">

</div>
</div>

@endsection