@extends('layouts.frontend.app')

@section('content')

<style>

/* HEADER */
.header-page{
background:#4a4e69;
color:white;
padding:60px 0;
text-align:center;
margin-bottom:40px;
}

/* CARD */
.detail-card{
background:white;
border-radius:16px;
box-shadow:0 6px 20px rgba(0,0,0,0.08);
padding:35px;
}

/* LAYOUT */
.detail-layout{
display:flex;
gap:50px;
align-items:flex-start;
flex-wrap:wrap;
}

/* FOTO */
.book-area{
text-align:center;
}

.book-photo{
width:220px;
height:300px;
object-fit:cover;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
margin-bottom:15px;
}

.book-title{
font-size:20px;
font-weight:700;
color:#333;
}

/* INFO */
.book-info{
flex:1;
}

/* INFO ITEM */
.info-item{
display:flex;
justify-content:space-between;
padding:12px 0;
border-bottom:1px solid #eee;
font-size:15px;
}

.info-label{
font-weight:600;
color:#555;
}

.info-value{
color:#333;
}

/* STATUS */
.status{
font-weight:600;
}

.status-belum{
color:#e74c3c;
}

.status-lunas{
color:#2ecc71;
}

/* INFO PEMBAYARAN */
.info-bayar{
background:#fff3cd;
border:1px solid #ffeeba;
color:#856404;
padding:15px;
border-radius:10px;
margin-top:20px;
font-size:14px;
}

/* BUTTON */
.btn-back{
display:inline-block;
margin-top:25px;
background:#4a4e69;
color:white;
padding:10px 18px;
border-radius:8px;
text-decoration:none;
font-size:14px;
transition:0.2s;
}

.btn-back:hover{
background:#3a3d56;
}

</style>


<div class="header-page">
<h2>Detail Denda</h2>
<p>Informasi lengkap denda keterlambatan</p>
</div>


<div class="container">

<div class="detail-card">

<div class="detail-layout">


<div class="book-area">

@if(optional($denda->peminjaman->buku)->photo)
<img src="{{ asset('storage/'.$denda->peminjaman->buku->photo) }}" class="book-photo">
@else
<img src="https://picsum.photos/220/300" class="book-photo">
@endif

<div class="book-title">
{{ optional($denda->peminjaman->buku)->judul ?? 'Buku Tidak Ditemukan' }}
</div>

</div>


<div class="book-info">

@php
$jumlah = $denda->hari_terlambat * 1000;
@endphp


<div class="info-item">
<span class="info-label">Penulis</span>
<span class="info-value">{{ optional($denda->peminjaman->buku)->penulis ?? '-' }}</span>
</div>

<div class="info-item">
<span class="info-label">Penerbit</span>
<span class="info-value">{{ optional($denda->peminjaman->buku)->penerbit ?? '-' }}</span>
</div>

<div class="info-item">
<span class="info-label">Nama Anggota</span>
<span class="info-value">{{ $denda->peminjaman->nama_anggota }}</span>
</div>

<div class="info-item">
<span class="info-label">Tanggal Kembali</span>
<span class="info-value">{{ $denda->peminjaman->tgl_kembali }}</span>
</div>

<div class="info-item">
<span class="info-label">Hari Terlambat</span>
<span class="info-value">{{ $denda->hari_terlambat }} Hari</span>
</div>

<div class="info-item">
<span class="info-label">Jumlah Denda</span>
<span class="info-value">
Rp {{ number_format($jumlah,0,',','.') }}
</span>
</div>

<div class="info-item">
<span class="info-label">Status Pembayaran</span>

@if($denda->status == 'selesai')
<span class="status status-lunas">Lunas</span>
@else
<span class="status status-belum">Belum Dibayar</span>
@endif

</div>


{{-- INFO PEMBAYARAN CASH --}}
@if($denda->status != 'selesai')

<div class="info-bayar">
Silakan melakukan pembayaran denda secara <b>CASH</b> di perpustakaan kepada petugas/admin.
</div>

@endif


<a href="{{ route('frontend.denda') }}" class="btn-back">
← Kembali ke Denda
</a>

</div>


</div>

</div>

</div>

@endsection