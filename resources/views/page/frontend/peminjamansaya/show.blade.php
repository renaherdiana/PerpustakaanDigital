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

.status-menunggu{ color:#f39c12; }
.status-dipinjam{ color:#2ecc71; }
.status-selesai{ color:#17a2b8; }
.status-ditolak{ color:#e74c3c; }

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
    <h2>Detail Peminjaman Buku</h2>
    <p>Informasi lengkap buku yang dipinjam</p>
</div>

<div class="container">

    <div class="detail-card">

        <div class="detail-layout">

            <div class="book-area">

                @if(optional($peminjaman->buku)->photo)
                    <img src="{{ asset('storage/'.$peminjaman->buku->photo) }}" class="book-photo">
                @else
                    <img src="https://picsum.photos/220/300" class="book-photo">
                @endif

                <div class="book-title">
                    {{ optional($peminjaman->buku)->judul ?? 'Buku Tidak Ditemukan' }}
                </div>

            </div>

            <div class="book-info">

                <div class="info-item">
                    <span class="info-label">Penulis</span>
                    <span class="info-value">{{ optional($peminjaman->buku)->penulis ?? '-' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Penerbit</span>
                    <span class="info-value">{{ optional($peminjaman->buku)->penerbit ?? '-' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Nama Anggota</span>
                    <span class="info-value">{{ $peminjaman->nama_anggota }}</span>
                </div>

                {{-- TAMBAHKAN JUMLAH PINJAM --}}
                <div class="info-item">
                    <span class="info-label">Jumlah Pinjam</span>
                    <span class="info-value">{{ $peminjaman->jumlah ?? '1' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Tanggal Pinjam</span>
                    <span class="info-value">{{ $peminjaman->tgl_pinjam }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Tanggal Kembali</span>
                    <span class="info-value">{{ $peminjaman->tgl_kembali }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Status</span>

                    @if($peminjaman->status=='menunggu')
                        <span class="status status-menunggu">Menunggu</span>
                    @elseif($peminjaman->status=='dipinjam')
                        <span class="status status-dipinjam">Dipinjam</span>
                    @elseif($peminjaman->status=='selesai')
                        <span class="status status-selesai">Selesai</span>
                    @elseif($peminjaman->status=='ditolak')
                        <span class="status status-ditolak">Ditolak</span>
                    @endif

                </div>

                <a href="{{ route('peminjamansaya') }}" class="btn-back">
                    ← Kembali ke Peminjaman Saya
                </a>

            </div>

        </div>

    </div>

</div>

@endsection