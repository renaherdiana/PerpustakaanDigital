@extends('layouts.frontend.app')

@section('content')

<style>
/* HEADER */
.header-page{
    background:#4a4e69;
    color:white;
    padding:70px 0;
    text-align:center;
    margin-bottom:40px;
}

/* SEARCH */
.search-box{
    display:flex;
    gap:10px;
    margin-bottom:25px;
}
.search-input{
    width:230px;
    padding:8px 12px;
    border:1px solid #cfd3e1;
    border-radius:6px;
}
.search-select{
    padding:8px 12px;
    border:1px solid #cfd3e1;
    border-radius:6px;
}

/* TABLE */
.table-custom{
    border-collapse:separate;
    border-spacing:0 12px;
    width:100%;
}
.table-header{
    background:#4a4e69;
    color:white;
}
.table-header th{
    padding:12px;
    text-align:center;
}
.table-row{
    background:white;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
    transition:0.2s;
}
.table-row:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(0,0,0,0.12);
}
.table-row td{
    padding:14px;
    text-align:center;
}

/* STATUS */
.badge{
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    color:white;
}
.badge-menunggu{ background:#f39c12; }
.badge-dipinjam{ background:#2ecc71; }
.badge-verifikasi{ background:#6c757d; }
.badge-selesai{ background:#17a2b8; }
.badge-ditolak{ background:#e74c3c; }
.badge-terlambat{ background:#e74c3c; }

/* BUTTON */
.btn-kembali,.btn-lihat,.btn-menunggu{
    border:none;
    padding:7px 16px;
    border-radius:8px;
    cursor:pointer;
    color:white;
    text-decoration:none;
}
.btn-kembali{ background:#3498db; }
.btn-lihat{ background:#3498db; }
.btn-menunggu{ background:#bdc3c7; }

/* POPUP */
.popup-bg{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    backdrop-filter:blur(5px);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:999;
}
.popup-box{
    background:white;
    color:#333;
    width:400px;
    padding:30px;
    border-radius:16px;
    text-align:left;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
    display:flex;
    flex-direction:column;
    gap:12px;
}
.popup-input{
    background:#eef2f7;
    padding:10px 12px;
    border-radius:8px;
    font-weight:600;
    border-left:4px solid #4a4e69;
}
.popup-status{
    padding:10px;
    border-radius:8px;
    font-weight:600;
    color:white;
}
.popup-denda{
    padding:10px;
    border-radius:8px;
    font-weight:600;
    color:#991b1b;
    background:#fde2e2;
}
.popup-btn{
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-top:15px;
}
.btn-batal{
    flex:1;
    background:#b0b6bd;
    border:none;
    padding:10px;
    border-radius:8px;
    color:white;
    cursor:pointer;
}
.btn-ajukan{
    flex:1;
    background:#4aa3ff;
    border:none;
    padding:10px;
    border-radius:8px;
    color:white;
    cursor:pointer;
}

/* TOAST SUCCESS */
#successMessage{
    position:fixed;
    top:20px;
    right:20px;
    background:#2ecc71;
    color:white;
    padding:15px 25px;
    border-radius:10px;
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
    z-index:1000;
}
</style>

<div class="header-page">
    <h2>Peminjaman Saya</h2>
</div>

<div class="container">

@if(session('success'))
<div id="successMessage">{{ session('success') }}</div>
<script>
    setTimeout(function(){
        document.getElementById('successMessage').style.display='none';
    }, 4000);
</script>
@endif

<div class="search-box">
    <input type="text" id="searchInput" class="search-input" placeholder="Cari Buku">
    <select id="statusFilter" class="search-select">
        <option value="">Semua Status</option>
        <option value="menunggu">Menunggu</option>
        <option value="dipinjam">Dipinjam</option>
        <option value="terlambat">Terlambat</option>
        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
        <option value="selesai">Selesai</option>
        <option value="ditolak">Ditolak</option>
    </select>
</div>

<table class="table-custom">
<thead class="table-header">
<tr>
<th>No</th>
<th>Judul Buku</th>
<th>Jumlah</th>
<th>Tgl Pinjam</th>
<th>Tgl Kembali</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody id="tableBody">
@foreach($peminjamans as $p)
@php
$today = \Carbon\Carbon::today();
$kembali = \Carbon\Carbon::parse($p->tgl_kembali);
$statusRow = $p->status;
if($p->status == 'dipinjam' && $today->gt($kembali)){
    $statusRow = 'terlambat';
}
@endphp
<tr class="table-row"
data-judul="{{ strtolower(optional($p->buku)->judul ?? '') }}"
data-status="{{ strtolower($statusRow) }}">
<td>{{ $peminjamans->firstItem() + $loop->index }}</td>
<td>{{ optional($p->buku)->judul }}</td>
<td>{{ $p->jumlah ?? $p->jumlah_pinjam }}</td>
<td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('Y-m-d') }}</td>
<td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('Y-m-d') }}</td>
<td>
@if($statusRow=='menunggu')
<span class="badge badge-menunggu">Menunggu</span>
@elseif($statusRow=='dipinjam')
<span class="badge badge-dipinjam">Dipinjam</span>
@elseif($statusRow=='terlambat')
<span class="badge badge-terlambat">Terlambat</span>
@elseif($statusRow=='menunggu_verifikasi')
<span class="badge badge-verifikasi">Menunggu Verifikasi</span>
@elseif($statusRow=='selesai')
<span class="badge badge-selesai">Selesai</span>
@elseif($statusRow=='ditolak')
<span class="badge badge-ditolak">Ditolak</span>
@endif
</td>
<td>
@if($statusRow=='menunggu')
<button class="btn-menunggu">Menunggu Persetujuan</button>
@elseif($statusRow=='dipinjam' || $statusRow=='terlambat')
<button class="btn-kembali"
onclick="openPopup('{{ $p->id }}','{{ optional($p->buku)->judul }}','{{ $p->jumlah ?? $p->jumlah_pinjam }}','{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('Y-m-d') }}','{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('Y-m-d') }}')">
Ajukan Pengembalian
</button>
@elseif($statusRow=='menunggu_verifikasi')
<button class="btn-menunggu">Menunggu Verifikasi</button>
@elseif($statusRow=='selesai')
<a href="{{ route('peminjamansaya.detail',$p->id) }}" class="btn-lihat">Lihat</a>
@elseif($statusRow=='ditolak')
<a href="{{ route('peminjamansaya.show',$p->id) }}" class="btn-lihat">Detail</a>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>

<div style="margin-top:20px;">
{{ $peminjamans->links('vendor.pagination.bootstrap-5') }}
</div>

</div>

<!-- POPUP -->
<div class="popup-bg" id="popupForm">
<div class="popup-box">
<h3>Ajukan Pengembalian</h3>
<div class="popup-input" id="judul"></div>
<div class="popup-input" id="jumlah"></div>
<div class="popup-input" id="tglPinjam"></div>
<div class="popup-input" id="tglKembali"></div>
<div class="popup-status" id="statusInfo"></div>
<div class="popup-denda" id="dendaInfo"></div>

<form action="{{ route('ajukan.pengembalian') }}" method="POST">
@csrf
<input type="hidden" name="peminjaman_id" id="peminjaman_id">
<div class="popup-btn">
<button type="button" class="btn-batal" onclick="closePopup()">Batal</button>
<button type="submit" class="btn-ajukan">Ajukan</button>
</div>
</form>
</div>
</div>

<script>
function openPopup(id, judul, jumlah, tglPinjam, tglKembali){
    document.getElementById("popupForm").style.display="flex";
    document.getElementById("peminjaman_id").value = id;
    document.getElementById("judul").innerHTML = "Judul Buku : " + judul;
    document.getElementById("jumlah").innerHTML = "Jumlah Buku : " + jumlah;
    document.getElementById("tglPinjam").innerHTML = "Tgl Pinjam : " + tglPinjam;
    document.getElementById("tglKembali").innerHTML = "Tgl Kembali : " + tglKembali;

    let today = new Date();
    let kembali = new Date(tglKembali);
    let diffTime = today - kembali;
    let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    let statusEl = document.getElementById("statusInfo");
    let dendaEl = document.getElementById("dendaInfo");

    if(diffDays > 0){
        let totalDenda = diffDays * 1000 * parseInt(jumlah);
        statusEl.innerHTML = "Status : Terlambat "+diffDays+" hari";
        statusEl.style.background="#e74c3c";
        dendaEl.innerHTML = "Estimasi Denda : Rp "+totalDenda.toLocaleString();
        dendaEl.style.display="block";
    } else {
        statusEl.innerHTML = "Status : Tepat Waktu";
        statusEl.style.background="#2ecc71";
        dendaEl.innerHTML = "";
    }
}

function closePopup(){
    document.getElementById("popupForm").style.display="none";
}
</script>

@endsection