@extends('layouts.frontend.app')

@section('content')

<style>

.banner{
background:#4a4e6d;
color:white;
text-align:center;
padding:60px;
margin-bottom:40px;
width:100%;
}

.katalog-container{
max-width:1200px;
margin:auto;
}

/* FORM */

.form-container{
max-width:720px;
margin:auto;
background:white;
padding:40px;
border-radius:14px;
box-shadow:0 10px 35px rgba(0,0,0,0.1);
transition:0.3s;
}

.form-container:hover{
box-shadow:0 15px 40px rgba(0,0,0,0.15);
}

.form-title{
text-align:center;
font-weight:600;
margin-bottom:30px;
color:#2c2c2c;
font-size:22px;
}

.form-group{
margin-bottom:22px;
}

.form-group label{
font-weight:500;
font-size:14px;
color:#444;
margin-bottom:6px;
display:block;
}

.form-control{
width:100%;
padding:11px 12px;
border-radius:10px;
border:1px solid #ddd;
transition:0.2s;
font-size:14px;
}

.form-control:focus{
outline:none;
border-color:#2bb3c0;
box-shadow:0 0 0 3px rgba(43,179,192,0.15);
}

.row{
display:flex;
gap:20px;
}

/* BUTTON */

.btn-ajukan{
margin-top:15px;
background:#2bb3c0;
border:none;
padding:11px 24px;
border-radius:30px;
color:white;
cursor:pointer;
float:right;
font-weight:500;
transition:0.25s;
}

.btn-ajukan:hover{
background:#229aa6;
transform:scale(1.05);
}

/* ===== POPUP ===== */

.notif{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
backdrop-filter:blur(6px);
justify-content:center;
align-items:center;
z-index:999;
}

.notif-box{
background:white;
color:#333;
padding:35px;
border-radius:16px;
width:360px;
text-align:center;
box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

/* ICON */

.success-icon{
font-size:42px;
margin-bottom:10px;
}

/* BUTTON */

.btn-ok{
margin-top:25px;
background:#2bb3c0;
border:none;
padding:10px 28px;
border-radius:10px;
color:white;
cursor:pointer;
}

.btn-ok:hover{
background:#2397a2;
}

</style>


<div class="banner">
<h2>Katalog Buku</h2>
<small>Home / Katalog Buku / Peminjaman</small>
</div>


<div class="katalog-container">

<div class="form-container">

<h3 class="form-title">Form Peminjaman Buku</h3>

<form action="{{ route('pinjam.store') }}" method="POST">

@csrf

<input type="hidden" name="buku_id" value="{{ $buku->id }}">

<div class="form-group">
<label>Nama</label>
<input 
type="text" 
name="nama" 
class="form-control" 
value="{{ session('anggota_nama') }}"
readonly
style="background:#f5f5f5; cursor:not-allowed;">
</div>


<div class="form-group">
<label>Judul Buku</label>
<input 
type="text" 
class="form-control" 
value="{{ $buku->judul }}" 
readonly>
</div>


<div class="form-group">
<label>Stok Buku</label>
<input 
type="text" 
class="form-control" 
value="{{ $buku->stok }}" 
readonly>
</div>


<div class="form-group">
<label>Jumlah Pinjam</label>
<input 
type="number" 
name="jumlah" 
class="form-control" 
min="1"
max="{{ $buku->stok }}"
required>
</div>


<div class="row">

<div class="form-group" style="flex:1;">
<label>Tanggal Pinjam</label>
<input 
type="date" 
name="tgl_pinjam" 
id="tgl_pinjam"
class="form-control"
value="{{ date('Y-m-d') }}"
readonly
style="background:#f5f5f5; cursor:not-allowed;"
required>
</div>


<div class="form-group" style="flex:1;">
<label>Tanggal Kembali</label>
<input 
type="date" 
name="tgl_kembali" 
id="tgl_kembali"
class="form-control" 
required>
</div>

</div>


<button type="submit" class="btn-ajukan">
Ajukan Peminjaman
</button>

</form>

</div>

</div>


@if(session('success'))

<div class="notif" id="notif">

<div class="notif-box">

<div class="success-icon">✅</div>

<h3>Pengajuan Berhasil</h3>

<p style="margin-top:6px;font-weight:500;">
Cek status pada menu <b>Peminjaman Saya</b>.
</p>

<button class="btn-ok" onclick="goKatalog()">OK</button>

</div>

</div>

@endif


<script>

document.addEventListener("DOMContentLoaded", function(){

const tglPinjam = document.getElementById('tgl_pinjam');
const tglKembali = document.getElementById('tgl_kembali');

// set min tgl_kembali = 1 hari setelah hari ini
const tomorrow = new Date(tglPinjam.value);
tomorrow.setDate(tomorrow.getDate() + 1);
tglKembali.min = tomorrow.toISOString().split('T')[0];

@if(session('success'))

let notif = document.getElementById("notif");

if(notif){
notif.style.display = "flex";
}

@endif

});

function goKatalog(){
window.location.href="{{ route('katalog') }}";
}

</script>

@endsection