@extends('layouts.backend.admin.app')

@section('content')

<style>
/* HEADER */
.header-detail{
    background:linear-gradient(120deg,#f1f5ff,#e8f0ff);
    padding:28px 35px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
    margin-bottom:30px;
}

.header-detail h4{
    margin:0;
    font-weight:700;
    font-size:22px;
    color:#4f7cff;
}

.header-detail p{
    margin-top:5px;
    color:#64748b;
}

/* CARD */
.card-detail{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    padding:40px;
    background:white;
}

/* FOTO */
.book-photo{
    width:160px;
    height:160px;
    object-fit:cover;
    border-radius:50%;
    margin:auto;
    display:block;
    margin-bottom:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
    border:4px solid white;
}

/* TITLE */
.detail-title{
    text-align:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:20px;
    color:#333;
}

/* GRID */
.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:20px;
}

/* BOX */
.info-box{
    background:#f8fafc;
    border-radius:12px;
    padding:18px 20px;
    border:1px solid #f1f5f9;
}

.label{
    font-size:13px;
    color:#64748b;
    margin-bottom:5px;
}

.value{
    font-size:16px;
    font-weight:600;
    color:#1e293b;
}

/* TOTAL DENDA BOX */
.total-denda-box{
    background:#fee2e2;
    border-radius:12px;
    padding:20px;
    border:1px solid #fca5a5;
    text-align:center;
    font-size:20px;
    font-weight:700;
    color:#b91c1c;
    margin-bottom:30px;
}

/* BUTTON */
.btn-back{
    background:#4f7cff;
    color:white;
    padding:11px 26px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition:0.2s;
}

.btn-back:hover{
    background:#3f6df0;
}

.btn-area{
    display:flex;
    justify-content:center;
    margin-top:35px;
}
</style>

<div class="header-detail">
    <h4>Detail Pengembalian</h4>
    <p>Informasi lengkap pengembalian buku anggota</p>
</div>

<div class="card card-detail">

{{-- FOTO BUKU --}}
@if(optional($pengembalian->peminjaman->buku)->photo)
    <img src="{{ asset('storage/'.$pengembalian->peminjaman->buku->photo) }}" class="book-photo">
@else
    <img src="https://picsum.photos/200" class="book-photo">
@endif

{{-- JUDUL --}}
<div class="detail-title">
    {{ optional($pengembalian->peminjaman->buku)->judul }}
</div>

@php
$terlambat = optional($pengembalian->denda)->hari_terlambat ?? 0;
$jumlahBuku = $pengembalian->peminjaman->jumlah ?? 1;
$dendaPerBukuPerHari = 1000; // sesuai index
$totalDenda = $terlambat * $jumlahBuku * $dendaPerBukuPerHari;
@endphp

<div class="detail-grid">

    <div class="info-box">
        <div class="label">Penulis</div>
        <div class="value">{{ optional($pengembalian->peminjaman->buku)->penulis ?? '-' }}</div>
    </div>

    <div class="info-box">
        <div class="label">Penerbit</div>
        <div class="value">{{ optional($pengembalian->peminjaman->buku)->penerbit ?? '-' }}</div>
    </div>

    <div class="info-box">
        <div class="label">Nama Anggota</div>
        <div class="value">{{ $pengembalian->peminjaman->nama_anggota ?? '-' }}</div>
    </div>

    <div class="info-box">
        <div class="label">Tanggal Pinjam</div>
        <div class="value">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_pinjam)->format('d M Y') }}</div>
    </div>

    <div class="info-box">
        <div class="label">Tanggal Kembali</div>
        <div class="value">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali)->format('d M Y') }}</div>
    </div>

    <div class="info-box">
        <div class="label">Tanggal Dikembalikan</div>
        <div class="value">{{ \Carbon\Carbon::parse($pengembalian->tgl_dikembalikan)->format('d M Y') }}</div>
    </div>

    <div class="info-box">
        <div class="label">Hari Terlambat</div>
        <div class="value">{{ $terlambat }} Hari</div>
    </div>

    <div class="info-box">
        <div class="label">Jumlah Buku</div>
        <div class="value">{{ $jumlahBuku }}</div>
    </div>

</div>

{{-- TOTAL DENDA --}}
<div class="total-denda-box">
@if($totalDenda > 0)
Total Denda: Rp {{ number_format($totalDenda,0,',','.') }}
@else
Tidak Ada Denda
@endif
</div>

<div class="btn-area">
    <a href="{{ route('admin.pengembalian.index') }}" class="btn-back">
        ← Kembali ke Data Pengembalian
    </a>
</div>

</div>

@endsection