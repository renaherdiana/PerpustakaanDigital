@extends('layouts.backend.admin.app')

@section('content')

<style>

/* HEADER (SOFT BLUE) */
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

/* FOTO BUKU */
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
    margin-bottom:15px;
    color:#333;
}

/* STATUS */
.status-badge{
    text-align:center;
    margin-bottom:30px;
}

.badge{
    padding:8px 16px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    display:inline-block;
}

.badge-wait{
    background:#fef3c7;
    color:#92400e;
}

.badge-borrow{
    background:#dbeafe;
    color:#1e40af;
}

.badge-done{
    background:#d1fae5;
    color:#065f46;
}

.badge-reject{
    background:#fee2e2;
    color:#991b1b;
}

.badge-late{
    background:#fecaca;
    color:#7f1d1d;
}

.badge-verif{
    background:#d1d5db;
    color:#111827;
}

/* GRID */
.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

/* INFO BOX */
.info-box{
    background:#f8fafc;
    border-radius:12px;
    padding:18px 20px;
    border:1px solid #f1f5f9;
    transition:0.2s;
}

.info-box:hover{
    background:#f1f5ff;
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
    <h4>Detail Peminjaman</h4>
    <p>Informasi lengkap peminjaman buku anggota</p>
</div>

<div class="card card-detail">

    {{-- FOTO BUKU --}}
    @if(optional($peminjaman->buku)->photo)
        <img src="{{ asset('storage/'.$peminjaman->buku->photo) }}" class="book-photo">
    @else
        <img src="https://picsum.photos/200/300" class="book-photo">
    @endif

    {{-- JUDUL BUKU --}}
    <div class="detail-title">
        {{ optional($peminjaman->buku)->judul }}
    </div>

    {{-- STATUS DI BAWAH JUDUL --}}
    <div class="status-badge">
        @if($peminjaman->status == 'menunggu')
            <span class="badge badge-wait">Menunggu</span>
        @elseif($peminjaman->status == 'dipinjam')
            <span class="badge badge-borrow">Dipinjam</span>
        @elseif($peminjaman->status == 'selesai')
            <span class="badge badge-done">Selesai</span>
        @elseif($peminjaman->status == 'menunggu_verifikasi')
            <span class="badge badge-verif">Menunggu Verifikasi</span>
        @elseif($peminjaman->status == 'ditolak')
            <span class="badge badge-reject">Ditolak</span>
        @elseif($peminjaman->status == 'terlambat')
            <span class="badge badge-late">Terlambat</span>
        @endif
    </div>

    {{-- GRID DETAIL --}}
    <div class="detail-grid">

        <div class="info-box">
            <div class="label">Penulis</div>
            <div class="value">{{ optional($peminjaman->buku)->penulis }}</div>
        </div>

        <div class="info-box">
            <div class="label">Penerbit</div>
            <div class="value">{{ optional($peminjaman->buku)->penerbit }}</div>
        </div>

        <div class="info-box">
            <div class="label">Nama Anggota</div>
            <div class="value">{{ $peminjaman->nama_anggota }}</div>
        </div>

        <div class="info-box">
            <div class="label">Jumlah Pinjam</div>
            <div class="value">{{ $peminjaman->jumlah }}</div>
        </div>

        <div class="info-box">
            <div class="label">Tanggal Pinjam</div>
            <div class="value">
                {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}
            </div>
        </div>

        <div class="info-box">
            <div class="label">Tanggal Kembali</div>
            <div class="value">
                {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d M Y') }}
            </div>
        </div>

    </div>

    {{-- ALASAN DITOLAK --}}
    @if($peminjaman->status == 'ditolak' && $peminjaman->alasan_ditolak)
    <div style="margin-top:20px; background:#fff5f5; border:1.5px solid #fecaca; border-radius:12px; padding:18px 22px; display:flex; gap:14px; align-items:flex-start;">
        <div style="font-size:22px; line-height:1;">🚫</div>
        <div>
            <div style="font-size:12px; font-weight:700; color:#ef4444; text-transform:uppercase; letter-spacing:.5px; margin-bottom:5px;">Alasan Ditolak</div>
            <div style="font-size:15px; color:#7f1d1d; font-weight:500;">{{ $peminjaman->alasan_ditolak }}</div>
        </div>
    </div>
    @endif

    {{-- BUTTON KEMBALI --}}
    <div class="btn-area">
        <a href="{{ route('admin.peminjaman.index') }}" class="btn-back">
            ← Kembali ke Data
        </a>
    </div>

</div>

@endsection