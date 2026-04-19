@extends('layouts.backend.admin.app')

@section('content')

<style>
.header-detail{
background:linear-gradient(120deg,#f1f5ff,#e8f0ff);
padding:28px 35px;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.06);
margin-bottom:30px;
}
.header-detail h4{ margin:0; font-weight:700; font-size:22px; color:#4f7cff; }
.header-detail p{ margin-top:5px; color:#64748b; }

.card-detail{
border:none; border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,0.05);
padding:40px; background:white;
}

.book-photo{
width:160px; height:160px; object-fit:cover;
border-radius:50%; margin:auto; display:block;
margin-bottom:20px;
box-shadow:0 8px 20px rgba(0,0,0,0.15);
border:4px solid white;
}

.detail-title{ text-align:center; font-size:28px; font-weight:700; margin-bottom:10px; color:#333; }

.status-badge{ display:inline-block; padding:6px 16px; border-radius:20px; font-size:13px; font-weight:600; margin-top:10px; }
.status-menunggu{ background:#fef3c7; color:#92400e; }
.status-lunas{ background:#d1fae5; color:#065f46; }
.status-area{ text-align:center; margin-bottom:30px; }

.detail-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }

.info-box{ background:#f8fafc; border-radius:12px; padding:18px 20px; border:1px solid #f1f5f9; }
.label{ font-size:13px; color:#64748b; margin-bottom:5px; }
.value{ font-size:16px; font-weight:600; color:#1e293b; }

.total-denda-box{
background:#fee2e2; border-radius:12px; padding:20px;
border:1px solid #fca5a5; text-align:center;
font-size:20px; font-weight:700; color:#b91c1c; margin-bottom:30px;
}

.btn-area{ display:flex; justify-content:center; margin-top:35px; }
.btn-back{
background:#4f7cff; color:white; padding:11px 26px;
border-radius:10px; text-decoration:none; font-weight:600; font-size:14px; transition:0.2s;
}
.btn-back:hover{ background:#3f6df0; }
</style>

<div class="header-detail">
<h4>Detail Denda</h4>
<p>Informasi lengkap denda
@if($denda->jenis == 'kerusakan') kerusakan buku
@elseif($denda->jenis == 'hilang') kehilangan buku
@else keterlambatan pengembalian buku
@endif
</p>
</div>

<div class="card card-detail">

@if(optional($denda->peminjaman->buku)->photo)
<img src="{{ asset('storage/'.$denda->peminjaman->buku->photo) }}" class="book-photo">
@else
<img src="https://picsum.photos/200" class="book-photo">
@endif

<div class="detail-title">{{ optional($denda->peminjaman->buku)->judul ?? '-' }}</div>

<div class="status-area">
@if($denda->status == 'selesai')
<span class="status-badge status-lunas">Lunas</span>
@else
<span class="status-badge status-menunggu">Menunggu Pembayaran</span>
@endif
</div>

<div class="detail-grid">

<div class="info-box">
<div class="label">Nama Anggota</div>
<div class="value">{{ $denda->peminjaman->nama_anggota ?? '-' }}</div>
</div>

<div class="info-box">
<div class="label">Judul Buku</div>
<div class="value">{{ optional($denda->peminjaman->buku)->judul ?? '-' }}</div>
</div>

<div class="info-box">
<div class="label">Tanggal Pinjam</div>
<div class="value">{{ \Carbon\Carbon::parse($denda->peminjaman->tgl_pinjam)->format('d M Y') }}</div>
</div>

<div class="info-box">
<div class="label">Tanggal Kembali</div>
<div class="value">{{ \Carbon\Carbon::parse($denda->peminjaman->tgl_kembali)->format('d M Y') }}</div>
</div>

<div class="info-box">
<div class="label">Jumlah Buku</div>
<div class="value">{{ $denda->peminjaman->jumlah ?? '-' }}</div>
</div>

<div class="info-box">
<div class="label">Jenis Denda</div>
<div class="value" style="color:{{ $denda->jenis == 'kerusakan' ? '#f97316' : '#dc2626' }}">
    @if($denda->jenis == 'kerusakan') Kerusakan Buku
    @elseif($denda->jenis == 'hilang') Buku Hilang
    @else Keterlambatan
    @endif
</div>
</div>

@if($denda->jenis == 'terlambat')
<div class="info-box">
<div class="label">Hari Terlambat</div>
<div class="value">{{ $denda->hari_terlambat }} Hari</div>
</div>
@endif

</div>

<div class="total-denda-box">
Total Denda: Rp {{ number_format($denda->denda, 0, ',', '.') }}
</div>

<div class="btn-area">
<a href="{{ route('admin.denda.index') }}" class="btn-back">← Kembali ke Data Denda</a>
</div>

</div>

@endsection
