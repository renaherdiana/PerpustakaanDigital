@extends('layouts.backend.admin.app')

@section('content')

<style>

.page-title{
font-weight:700;
font-size:20px;
margin-bottom:20px;
color:#3b3b3b;
}

/* CARD STATISTIK */

.report-cards{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:25px;
}

.report-card{
display:flex;
align-items:center;
gap:15px;
border-radius:16px;
padding:22px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
transition:0.3s;
}

.report-card:hover{
transform:translateY(-3px);
}

/* WARNA CARD */

.card-buku{background:#eef2ff;}
.card-pinjam{background:#ecfdf5;}
.card-kembali{background:#fff7ed;}
.card-denda{background:#fef2f2;}

/* ICON */

.report-icon{
font-size:30px;
width:48px;
height:48px;
display:flex;
align-items:center;
justify-content:center;
border-radius:12px;
}

.icon-buku{background:#dbeafe;color:#2563eb;}
.icon-pinjam{background:#d1fae5;color:#059669;}
.icon-kembali{background:#ffedd5;color:#ea580c;}
.icon-denda{background:#fee2e2;color:#dc2626;}

.report-info h3{
margin:0;
font-size:24px;
font-weight:700;
}

.report-info p{
margin:0;
font-size:13px;
color:#666;
}

/* CARD TABLE */

.card-custom{
border:none;
border-radius:14px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
padding:20px;
}

/* FILTER */

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

.filter-left input,
.filter-left select{
padding:8px 12px;
border-radius:10px;
border:1px solid #e0e0e0;
font-size:14px;
}

/* BUTTON TAMBAH LAPORAN */

.btn-primary{
background:#7c6cf3;
border:none;
border-radius:10px;
font-size:14px;
padding:8px 18px;
font-weight:500;
}

/* TABLE */

.table thead{
background:#f8f8fb;
}

.table th{
font-weight:600;
color:#555;
}

.table td{
vertical-align:middle;
}

/* FILE BADGE */

.file-badge{
background:#fee2e2;
color:#991b1b;
padding:6px 10px;
border-radius:8px;
font-size:12px;
}

/* ACTION BUTTON */

.btn-sm{
border-radius:8px;
font-size:12px;
padding:5px 12px;
border:none;
}

/* SHOW */

.btn-show{
background:#e0e7ff;
color:#3730a3;
}

.btn-show:hover{
background:#c7d2fe;
}

/* DELETE */

.btn-delete{
background:#fee2e2;
color:#991b1b;
}

.btn-delete:hover{
background:#fecaca;
}

</style>

<h5 class="page-title">Data Laporan</h5>

<!-- CARD STATISTIK -->

<div class="report-cards">

<div class="report-card card-buku">
<div class="report-icon icon-buku">📚</div>
<div class="report-info">
<h3>12</h3>
<p>Laporan Buku</p>
</div>
</div>

<div class="report-card card-pinjam">
<div class="report-icon icon-pinjam">📖</div>
<div class="report-info">
<h3>8</h3>
<p>Laporan Peminjaman</p>
</div>
</div>

<div class="report-card card-kembali">
<div class="report-icon icon-kembali">🔁</div>
<div class="report-info">
<h3>7</h3>
<p>Laporan Pengembalian</p>
</div>
</div>

<div class="report-card card-denda">
<div class="report-icon icon-denda">💰</div>
<div class="report-info">
<h3>5</h3>
<p>Laporan Denda</p>
</div>
</div>

</div>

<div class="card card-custom">
<div class="card-body">

<div class="filter-area">

<div class="filter-left">

<input type="text" id="searchInput" placeholder="Cari Laporan...">

<select id="kategoriFilter">
<option value="">Semua Kategori</option>
<option value="Buku">Buku</option>
<option value="Peminjaman">Peminjaman</option>
<option value="Pengembalian">Pengembalian</option>
<option value="Denda">Denda</option>
</select>

</div>

<button class="btn btn-primary">
+ Tambah Laporan
</button>

</div>

<div class="table-responsive">

<table class="table align-middle" id="laporanTable">

<thead>
<tr>
<th>No</th>
<th>Nama Laporan</th>
<th>Kategori</th>
<th>Tanggal Upload</th>
<th>File</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<tr>
<td>1</td>
<td>Laporan Data Buku Mei 2026</td>
<td>Buku</td>
<td>20 Mei 2026</td>
<td><span class="file-badge">📄 laporan-buku.pdf</span></td>
<td>
<button class="btn btn-show btn-sm">👁 Show</button>
<button class="btn btn-delete btn-sm deleteBtn">🗑 Delete</button>
</td>
</tr>

<tr>
<td>2</td>
<td>Laporan Peminjaman Mei 2026</td>
<td>Peminjaman</td>
<td>21 Mei 2026</td>
<td><span class="file-badge">📄 peminjaman.pdf</span></td>
<td>
<button class="btn btn-show btn-sm">👁 Show</button>
<button class="btn btn-delete btn-sm deleteBtn">🗑 Delete</button>
</td>
</tr>

</tbody>

</table>

</div>
</div>
</div>

<script>

/* DELETE */

document.querySelectorAll(".deleteBtn").forEach(btn=>{
btn.onclick=function(){
if(confirm("Yakin ingin menghapus laporan ini?")){
this.closest("tr").remove();
}
}
});

/* SEARCH + FILTER */

const searchInput=document.getElementById("searchInput");
const kategoriFilter=document.getElementById("kategoriFilter");

function filterTable(){

let filter=searchInput.value.toLowerCase();
let kategori=kategoriFilter.value.toLowerCase();

document.querySelectorAll("#laporanTable tbody tr").forEach(row=>{

let nama=row.cells[1].textContent.toLowerCase();
let kat=row.cells[2].textContent.toLowerCase();

let matchSearch=nama.includes(filter);
let matchKategori=kategori===""||kat===kategori;

row.style.display=(matchSearch&&matchKategori)?"":"none";

});

}

searchInput.addEventListener("keyup",filterTable);
kategoriFilter.addEventListener("change",filterTable);

</script>

@endsection