@extends('layouts.backend.admin.app')

@section('content')

<style>
.header-detail{
    background:linear-gradient(120deg,#f1f5ff,#e8f0ff);
    padding:28px 35px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
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

.card-detail{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    padding:40px;
    background:white;
}

.user-photo{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:6px solid #f1f5ff;
    box-shadow:0 6px 16px rgba(0,0,0,0.08);
    display:block;
    margin:auto;
    margin-bottom:20px;
}

.user-name{
    text-align:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:20px;
    color:#333;
}

.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:20px;
}

.info-box{
    background:#f8fafc;
    border-radius:12px;
    padding:18px 20px;
    border:1px solid #f1f5f9;
    transition:0.2s;
    display:flex;
    flex-direction:column;
    align-items: flex-start; /* kiri semua */
}

.info-box:hover{
    background:#f1f5ff;
}

.label{
    font-size:13px;
    color:#64748b;
    margin-bottom:6px;
}

.value{
    font-size:16px;
    font-weight:600;
    color:#1e293b;
    display:block;
    text-align:left; /* kiri */
}

.badge{
    padding:6px 14px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
    display:inline-block;
}

.badge-active{
    background:#dcfce7;
    color:#166534;
}

.badge-inactive{
    background:#fee2e2;
    color:#991b1b;
}

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

@media(max-width:767px){
    .detail-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="header-detail">
    <h4>Detail Anggota</h4>
    <p>Informasi lengkap anggota perpustakaan</p>
</div>

<div class="card card-detail">

    <img src="https://ui-avatars.com/api/?name={{ urlencode($anggota->nama) }}&background=4f7cff&color=fff&size=200" class="user-photo">

    <div class="user-name">
        {{ $anggota->nama }}
    </div>

    <div class="detail-grid">
        <div class="info-box">
            <div class="label">NIS</div>
            <div class="value">{{ $anggota->nis }}</div>
        </div>

        <div class="info-box">
            <div class="label">Email</div>
            <div class="value">{{ $anggota->email }}</div>
        </div>

        <div class="info-box">
            <div class="label">Kelas</div>
            <div class="value">{{ $anggota->kelas }}</div>
        </div>

        <div class="info-box">
            <div class="label">Status</div>
            <div class="value">
                @if($anggota->status == 'aktif')
                    <span class="badge badge-active">Aktif</span>
                @else
                    <span class="badge badge-inactive">Tidak Aktif</span>
                @endif
            </div>
        </div>
    </div>

    <div class="btn-area">
        <a href="{{ route('admin.anggota.index') }}" class="btn-back">
            ← Kembali
        </a>
    </div>

</div>

@endsection