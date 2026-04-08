@extends('layouts.backend.superadmin.app')

@section('content')

<style>

/* HEADER */
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

/* CARD */
.card-detail{
border:none;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,0.05);
padding:40px;
background:white;
}

/* FOTO */
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

/* NAMA */
.user-name{
text-align:center;
font-size:28px;
font-weight:700;
margin-bottom:10px;
color:#333;
}

/* STATUS */
.status-area{
text-align:center;
margin-bottom:35px;
}

/* GRID */
.detail-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

/* BOX */
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

/* BADGE */
.badge{
padding:8px 18px;
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

/* BUTTON */
.btn-back{
background:#4f7cff;
color:white;
padding:11px 26px;
border-radius:10px;
text-decoration:none;
font-weight:600;
font-size:14px;
}

.btn-area{
display:flex;
justify-content:center;
margin-top:35px;
}

</style>


<div class="header-detail">
<h4>Detail Petugas</h4>
<p>Informasi lengkap petugas perpustakaan</p>
</div>


<div class="card card-detail">

{{-- FOTO --}}
@if($user->photo)
<img src="{{ asset('storage/'.$user->photo) }}" class="user-photo">
@else
<img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f7cff&color=fff&size=200" class="user-photo">
@endif


{{-- NAMA --}}
<div class="user-name">
{{ $user->name }}
</div>


{{-- STATUS --}}
<div class="status-area">

@if($user->status == 'aktif')
<span class="badge badge-active">Aktif</span>
@else
<span class="badge badge-inactive">Tidak Aktif</span>
@endif

</div>


<div class="detail-grid">

<div class="info-box">
<div class="label">Email</div>
<div class="value">{{ $user->email }}</div>
</div>

<div class="info-box">
<div class="label">No Telephone</div>
<div class="value">{{ $user->phone }}</div>
</div>

<div class="info-box">
<div class="label">Role</div>
<div class="value">{{ ucfirst($user->role) }}</div>
</div>

<div class="info-box">
<div class="label">Tanggal Dibuat</div>
<div class="value">{{ $user->created_at->format('d M Y') }}</div>
</div>

</div>


<div class="btn-area">
<a href="{{ route('superadmin.datauser.index') }}" class="btn-back">
← Kembali
</a>
</div>

</div>

@endsection