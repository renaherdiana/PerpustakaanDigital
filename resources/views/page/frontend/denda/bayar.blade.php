@extends('layouts.frontend.app')

@section('content')

<style>

/* HEADER */
.header-page{
background:linear-gradient(135deg,#4b4e6d,#6c70a3);
color:white;
text-align:center;
padding:70px 0;
margin-bottom:50px;
}

.header-page h2{
font-weight:600;
letter-spacing:1px;
}

/* TITLE */
.title-section{
text-align:center;
margin-bottom:35px;
color:#4b4e6d;
font-weight:600;
font-size:20px;
}

/* CARD FORM */
.card-bayar{
background:white;
border-radius:14px;
padding:40px;
width:600px;
margin:auto;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
transition:all .25s ease;
}

.card-bayar:hover{
transform:translateY(-3px);
box-shadow:0 14px 30px rgba(0,0,0,0.12);
}

/* FORM */
.form-label{
font-size:14px;
color:#555;
margin-bottom:6px;
font-weight:500;
}

.form-control{
border-radius:10px;
height:42px;
border:1px solid #dcdde1;
padding-left:38px;
transition:all .2s;
}

.form-control:focus{
border-color:#4b4e6d;
box-shadow:0 0 0 2px rgba(75,78,109,.15);
}

/* INPUT ICON */
.input-group{
position:relative;
}

.input-group i{
position:absolute;
left:12px;
top:50%;
transform:translateY(-50%);
color:#6c757d;
font-size:15px;
}

/* BUTTON */
.btn-batal{
background:#6c757d;
color:white;
padding:8px 24px;
border-radius:10px;
border:none;
text-decoration:none;
transition:.2s;
}

.btn-batal:hover{
background:#5a6268;
color:white;
}

/* BUTTON BAYAR */
.btn-bayar{
background:#3498db;
color:white;
padding:8px 26px;
border-radius:10px;
border:none;
font-weight:500;
transition:all .2s;
}

.btn-bayar:hover{
background:#2980b9;
transform:translateY(-1px);
box-shadow:0 6px 12px rgba(0,0,0,0.15);
}

.btn-bayar:active{
transform:scale(.96);
}

/* SELECT */
select.form-control{
padding-left:10px;
}

/* RESPONSIVE */
@media(max-width:768px){

.card-bayar{
width:95%;
padding:25px;
}

}

</style>


<!-- HEADER -->
<div class="header-page">
<h2>Denda</h2>
<div style="font-size:14px;opacity:0.85;">
Home / Denda
</div>
</div>


<div class="container">

<h5 class="title-section">
<i class="bi bi-wallet2"></i>
Pembayaran Denda
</h5>


<div class="card-bayar">

<form action="{{ route('bayar.denda',$denda->id) }}" method="POST">

@csrf

@php
$jumlah = $denda->hari_terlambat * 1000;
@endphp


<!-- JUDUL BUKU -->
<div class="mb-3">

<label class="form-label">Judul Buku</label>

<div class="input-group">
<i class="bi bi-book"></i>
<input type="text" class="form-control"
value="{{ $denda->peminjaman->buku->judul }}"
readonly>
</div>

</div>


<!-- TOTAL DENDA -->
<div class="mb-3">

<label class="form-label">Total Denda</label>

<div class="input-group">
<i class="bi bi-cash-stack"></i>
<input type="text" class="form-control"
value="Rp {{ number_format($jumlah,0,',','.') }}"
readonly>
</div>

</div>


<div class="row">

<!-- TGL TERLAMBAT -->
<div class="col-md-6 mb-3">

<label class="form-label">Tanggal Terlambat</label>

<div class="input-group">
<i class="bi bi-calendar-event"></i>
<input type="text" class="form-control"
value="{{ \Carbon\Carbon::parse($denda->peminjaman->tgl_kembali)->format('d-m-Y') }}"
readonly>
</div>

</div>


<!-- METODE -->
<div class="col-md-6 mb-3">

<label class="form-label">Metode Pembayaran</label>

<select name="metode" class="form-control">

<option value="dana">Dana</option>
<option value="ovo">OVO</option>
<option value="gopay">Gopay</option>

</select>

</div>

</div>


<div class="text-end mt-4">

<a href="{{ route('frontend.denda') }}" class="btn btn-batal">
Batal
</a>

<button type="submit" class="btn btn-bayar">
<i class="bi bi-credit-card"></i> Bayar
</button>

</div>


</form>

</div>

</div>

@endsection