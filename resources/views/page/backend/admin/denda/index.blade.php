@extends('layouts.backend.admin.app')

@section('content')

<style>
.page-title{ font-weight:700; font-size:20px; margin-bottom:25px; color:#3b3b3b; }
.card-custom{ border:none; border-radius:14px; box-shadow:0 6px 18px rgba(0,0,0,0.05); padding:20px; }

.filter-area{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.filter-left{
display:flex;
gap:15px;
}

.filter-left input{
min-width:250px;
padding:8px 12px;
border-radius:10px;
border:1px solid #e0e0e0;
font-size:14px;
}

.table thead{ background:#f8f8fb; }

.table th{
font-weight:600;
color:#555;
}

.table td{
vertical-align:middle;
}

.badge{
padding:6px 12px;
border-radius:20px;
font-size:12px;
}

.badge-wait{
background:#fef3c7;
color:#92400e;
}

.badge-paid{
background:#d1fae5;
color:#065f46;
}

.btn-action{
border:none;
border-radius:8px;
font-size:12px;
padding:6px 10px;
display:inline-flex;
align-items:center;
gap:4px;
cursor:pointer;
}

.btn-verify{
background:#dcfce7;
color:#166534;
}

.btn-show{
background:#f1f5f9;
color:#334155;
text-decoration:none;
}

.empty-data{
text-align:center;
padding:40px;
color:#888;
font-size:14px;
}
</style>

<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Data Denda</h5>

<div class="filter-area">
<div class="filter-left">
<input type="text" id="searchInput" placeholder="Cari Anggota / Buku...">
</div>
</div>

<div class="table-responsive">

<table class="table align-middle" id="dendaTable">

<thead>
<tr>
<th>No</th>
<th>Nama Anggota</th>
<th>Judul Buku</th>
<th>Tgl Kembali</th>
<th>Tgl Dikembalikan</th>
<th>Hari Terlambat</th>
<th>Jumlah Denda</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse($dendas as $item)

@php
$terlambat = $item->denda->hari_terlambat ?? 0;
$totalDenda = $terlambat * 1000;
$status = $item->denda->status ?? 'menunggu';
@endphp

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->peminjaman->nama_anggota ?? '-' }}</td>

<td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>

<td>
{{ \Carbon\Carbon::parse($item->peminjaman->tgl_kembali)->format('d M Y') }}
</td>

<td>
{{ \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('d M Y') }}
</td>

<td>
{{ $terlambat }} Hari
</td>

<td>
Rp {{ number_format($totalDenda,0,',','.') }}
</td>

<td>

@if($status == 'selesai')

<span class="badge badge-paid">
Lunas
</span>

@else

<span class="badge badge-wait">
Menunggu Pembayaran
</span>

@endif

</td>

<td>

@if($status != 'selesai')

<form action="{{ route('admin.denda.bayar',$item->id) }}" method="POST" style="display:inline;">
@csrf
<button type="submit" class="btn-action btn-verify">
✔ Verifikasi
</button>
</form>

@else

<a href="{{ route('admin.denda.show',$item->id) }}" class="btn-action btn-show">
👁 Show
</a>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="9" class="empty-data">
Belum ada data denda
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>
</div>

<script>

const searchInput = document.getElementById("searchInput");
const table = document.getElementById("dendaTable");
const rows = table.getElementsByTagName("tr");

searchInput.addEventListener("keyup",function(){

const value = this.value.toLowerCase();

for(let i=1;i<rows.length;i++){

const anggota = rows[i].cells[1].textContent.toLowerCase();
const buku = rows[i].cells[2].textContent.toLowerCase();

if(anggota.includes(value) || buku.includes(value)){
rows[i].style.display="";
}else{
rows[i].style.display="none";
}

}

});

</script>

@endsection