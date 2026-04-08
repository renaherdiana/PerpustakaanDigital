@extends('layouts.frontend.app')

@section('content')

<style>
/* HEADER */
.header-page{
background:#4b4e6d;
color:white;
text-align:center;
padding:60px 0;
}

.header-page h2{
font-weight:600;
}

.breadcrumb-custom{
font-size:14px;
opacity:0.8;
}

/* CARD TOTAL DENDA */
.card-denda{
background:#e9ecef;
border-radius:12px;
padding:22px;
margin:40px auto;
width:450px;
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.card-denda i{
font-size:28px;
margin-right:12px;
}

/* INFO PEMBAYARAN */
.info-bayar{
background:#fff3cd;
border:1px solid #ffeeba;
color:#856404;
padding:15px;
border-radius:10px;
margin-bottom:25px;
font-size:14px;
}

/* TABLE */
.table-custom{
background:white;
border-radius:12px;
overflow:hidden;
box-shadow:0 3px 10px rgba(0,0,0,0.08);
}

.table thead{
background:#4b4e6d;
color:white;
}

/* STATUS */
.status-lunas{
background:#2ecc71;
color:white;
padding:6px 14px;
border-radius:20px;
font-size:13px;
}

.status-belum{
background:#ff3b30;
color:white;
padding:6px 14px;
border-radius:20px;
font-size:13px;
}

/* BUTTON */
.btn-detail{
background:#3498db;
color:white;
border:none;
padding:7px 18px;
border-radius:8px;
font-size:14px;
font-weight:500;
display:inline-flex;
align-items:center;
gap:6px;
transition:all 0.2s ease;
text-decoration:none;
}

.btn-detail:hover{
background:#2980b9;
color:white;
transform:translateY(-1px);
box-shadow:0 4px 10px rgba(0,0,0,0.15);
text-decoration:none;
}

/* PAGINATION */
.pagination{
margin-top:25px;
justify-content:center;
}

.page-link{
color:#4b4e6d;
border-radius:8px !important;
}

.page-item.active .page-link{
background:#4b4e6d;
border-color:#4b4e6d;
}
</style>

<!-- HEADER -->
<div class="header-page">
<h2>Denda Saya</h2>
<div class="breadcrumb-custom">
Home / Denda
</div>
</div>

<div class="container">

<!-- TOTAL DENDA -->
@php
$totalDenda = 0;
@endphp

@foreach($dendas as $item)
@php
$hariTerlambat = $item->hari_terlambat ?? 0;
$jumlahBuku = $item->peminjaman->jumlah ?? 1;
$dendaPerBukuPerHari = 1000;
$totalDenda += $hariTerlambat * $jumlahBuku * $dendaPerBukuPerHari;
@endphp
@endforeach

<div class="card-denda">
<i class="bi bi-cash-stack"></i>
Total Denda Aktif :
<b class="ms-2">
Rp {{ number_format($totalDenda,0,',','.') }}
</b>
</div>

<!-- INFO BAYAR CASH -->
<div class="info-bayar">
<b>Pembayaran Denda</b><br>
Pembayaran denda dilakukan secara <b>CASH</b> di perpustakaan kepada petugas/admin.
</div>

<!-- TABLE -->
<div class="table-custom">
<table class="table mb-0">
<thead>
<tr>
<th>No</th>
<th>Judul Buku</th>
<th>Tanggal Terlambat</th>
<th>Jumlah Buku</th>
<th>Jumlah Denda</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@forelse($dendas as $item)

@php
$hariTerlambat = $item->hari_terlambat ?? 0;
$jumlahBuku = $item->peminjaman->jumlah ?? 1;
$dendaPerBukuPerHari = 1000;
$totalItemDenda = $hariTerlambat * $jumlahBuku * $dendaPerBukuPerHari;
@endphp

<tr>
<td>{{ $dendas->firstItem() + $loop->index }}</td>
<td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
<td>{{ $hariTerlambat }} Hari</td>
<td>{{ $jumlahBuku }}</td>
<td>Rp {{ number_format($totalItemDenda,0,',','.') }}</td>
<td>
@if($item->status == 'selesai')
<span class="status-lunas">Lunas</span>
@else
<span class="status-belum">Belum Dibayar</span>
@endif
</td>
<td>
<a href="{{ route('denda.detail', $item->id) }}" class="btn-detail">
<i class="bi bi-eye"></i> Detail
</a>
</td>
</tr>

@empty
<tr>
<td colspan="7" class="text-center">
Tidak ada data denda
</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- PAGINATION -->
<div class="mt-4">
{{ $dendas->links() }}
</div>

</div>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
icon: 'success',
title: 'Berhasil!',
text: 'Data berhasil diperbarui',
confirmButtonColor: '#4b4e6d'
})
</script>
@endif

@endsection