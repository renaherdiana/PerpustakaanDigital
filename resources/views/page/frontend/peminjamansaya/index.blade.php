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
.badge-ditolak-pengembalian{ background:#f97316; }

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
.popup-alasan{
    padding:10px;
    border-radius:8px;
    font-weight:600;
    color:#92400e;
    background:#fef3c7;
    border-left:4px solid #f59e0b;
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

/* TOAST */
.toast-msg{
    position:fixed;
    top:20px;
    right:20px;
    padding:15px 25px;
    border-radius:10px;
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
    z-index:1000;
    color:white;
}
#successMessage{ background:#2ecc71; }
#errorMessage{ background:#e74c3c; }
</style>

<div class="header-page">
    <h2>Peminjaman Saya</h2>
</div>

<div class="container">

@if(session('success'))
<div id="successMessage" class="toast-msg">{{ session('success') }}</div>
<script>setTimeout(function(){ document.getElementById('successMessage').style.display='none'; }, 4000);</script>
@endif

@if(session('error'))
<div id="errorMessage" class="toast-msg">{{ session('error') }}</div>
<script>setTimeout(function(){ document.getElementById('errorMessage').style.display='none'; }, 5000);</script>
@endif

<form method="GET" action="{{ route('peminjamansaya') }}" class="search-box">
    <input type="text" name="search" class="search-input" placeholder="Cari Buku" value="{{ request('search') }}">
    <select name="status" class="search-select" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
        <option value="dipinjam" {{ request('status')=='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
        <option value="terlambat" {{ request('status')=='terlambat' ? 'selected' : '' }}>Terlambat</option>
        <option value="menunggu_verifikasi" {{ request('status')=='menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
        <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
        <option value="ditolak_pengembalian" {{ request('status')=='ditolak_pengembalian' ? 'selected' : '' }}>Ditolak Pengembalian</option>
    </select>
    <button type="submit" style="padding:8px 16px; background:#4a4e69; color:white; border:none; border-radius:6px; cursor:pointer;">Cari</button>
</form>

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
@forelse($peminjamans as $p)
@php
$today = \Carbon\Carbon::today();
$kembali = \Carbon\Carbon::parse($p->tgl_kembali);
$statusRow = $p->status;
if($p->status == 'dipinjam' && $today->gt($kembali)){
    $statusRow = 'terlambat';
}
$hasDendaBelumLunas = $p->denda && $p->denda->status == 'menunggu';
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
@elseif($statusRow=='ditolak_pengembalian')
<span class="badge badge-ditolak-pengembalian">Ditolak Pengembalian</span>
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
<a href="{{ route('peminjamansaya.detail',$p->id) }}" class="btn-lihat">Detail</a>
@elseif($statusRow=='ditolak_pengembalian')
@if($hasDendaBelumLunas)
<a href="{{ route('frontend.denda') }}" class="btn-kembali" style="background:#e74c3c;">Bayar Denda Dulu</a>
@else
<button class="btn-kembali" style="background:#f97316;"
onclick="openPopupAjukanLagi('{{ $p->id }}','{{ optional($p->buku)->judul }}','{{ $p->jumlah ?? $p->jumlah_pinjam }}','{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('Y-m-d') }}','{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('Y-m-d') }}','{{ addslashes($p->alasan_ditolak) }}')">
Ajukan Lagi
</button>
@endif
@endif
</td>
</tr>
@empty
<tr>
    <td colspan="7" style="text-align:center; padding:50px; color:#aaa;">
        <div style="font-size:15px; font-weight:600; color:#888;">Belum ada peminjaman</div>
        <div style="font-size:13px; margin-top:4px; color:#bbb;">Kamu belum pernah meminjam buku</div>
    </td>
</tr>
@endforelse
</tbody>
</table>

<div style="margin-top:20px;">
{{ $peminjamans->links('vendor.pagination.bootstrap-5') }}
</div>

</div>

<!-- POPUP AJUKAN PENGEMBALIAN -->
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

<!-- POPUP AJUKAN LAGI (setelah ditolak pengembalian) -->
<div class="popup-bg" id="popupAjukanLagi">
<div class="popup-box">
<h3>Ajukan Pengembalian Lagi</h3>
<div class="popup-input" id="al_judul"></div>
<div class="popup-input" id="al_jumlah"></div>
<div class="popup-input" id="al_tglPinjam"></div>
<div class="popup-input" id="al_tglKembali"></div>
<div class="popup-alasan" id="al_alasan"></div>
<div class="popup-status" id="al_statusInfo"></div>
<div class="popup-denda" id="al_dendaInfo"></div>

<form action="{{ route('ajukan.pengembalian') }}" method="POST">
@csrf
<input type="hidden" name="peminjaman_id" id="al_peminjaman_id">
<div class="popup-btn">
<button type="button" class="btn-batal" onclick="closePopupAjukanLagi()">Batal</button>
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

    let today = new Date(); today.setHours(0,0,0,0);
    let kembali = new Date(tglKembali); kembali.setHours(0,0,0,0);
    let diffDays = Math.round((today - kembali) / (1000 * 60 * 60 * 24));

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

function openPopupAjukanLagi(id, judul, jumlah, tglPinjam, tglKembali, alasan){
    document.getElementById("popupAjukanLagi").style.display="flex";
    document.getElementById("al_peminjaman_id").value = id;
    document.getElementById("al_judul").innerHTML = "Judul Buku : " + judul;
    document.getElementById("al_jumlah").innerHTML = "Jumlah Buku : " + jumlah;
    document.getElementById("al_tglPinjam").innerHTML = "Tgl Pinjam : " + tglPinjam;
    document.getElementById("al_tglKembali").innerHTML = "Tgl Kembali : " + tglKembali;
    document.getElementById("al_alasan").innerHTML = "⚠️ Alasan Ditolak : " + alasan;

    let today = new Date(); today.setHours(0,0,0,0);
    let kembali = new Date(tglKembali); kembali.setHours(0,0,0,0);
    let diffDays = Math.round((today - kembali) / (1000 * 60 * 60 * 24));

    let statusEl = document.getElementById("al_statusInfo");
    let dendaEl = document.getElementById("al_dendaInfo");
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

function closePopupAjukanLagi(){
    document.getElementById("popupAjukanLagi").style.display="none";
}
</script>

@endsection
