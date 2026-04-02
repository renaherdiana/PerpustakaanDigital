@extends('layouts.backend.superadmin.app')

@section('content')

<style>

/* PAGE TITLE */
.page-title{
    font-weight:700;
    font-size:20px;
    margin-bottom:25px;
    color:#3b3b3b;
}

/* CARD */
.card-custom{
    border:none;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
    padding:20px;
}

/* FILTER AREA */
.filter-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.filter-area .filter-left{
    display:flex;
    gap:15px;
    align-items:center;
}

.filter-area input{
    min-width:300px;
    font-size:14px;
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #e0e0e0;
}

.filter-area select{
    width:180px;
    font-size:14px;
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #e0e0e0;
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

.table tbody tr:hover{
    background:#fdfdff;
}

/* STATUS BADGE */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:500;
}

.badge-active{
    background:#d1fae5;
    color:#065f46;
}

.badge-inactive{
    background:#fee2e2;
    color:#991b1b;
}

/* BUTTON SOFT */
.btn-detail{
    border:none;
    border-radius:8px;
    font-size:12px;
    padding:6px 10px;
    background:#f1f5f9;
    color:#334155;
}

</style>

<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Laporan Anggota</h5>

<!-- FILTER -->
<div class="filter-area">

<div class="filter-left">
<input type="text" id="searchInput" placeholder="Cari Nama Anggota...">

<select id="statusFilter">
<option value="">Semua Status</option>
<option value="aktif">Aktif</option>
<option value="tidak aktif">Tidak Aktif</option>
</select>
</div>

</div>

<!-- TABLE -->
<div class="table-responsive">
<table class="table align-middle" id="anggotaTable">

<thead>
<tr>
<th>No</th>
<th>Nama Anggota</th>
<th>Kelas</th>
<th>No Telephone</th>
<th>Total Pinjam</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<tr>
<td>1</td>
<td>Rena Herdiana</td>
<td>XI RPL 1</td>
<td>0895335053813</td>
<td>5 Buku</td>
<td class="status"><span class="badge badge-active">Aktif</span></td>
<td>
<button class="btn-detail">👁 Detail</button>
</td>
</tr>

<tr>
<td>2</td>
<td>Virda Ainun Nazah</td>
<td>XI RPL 2</td>
<td>0895335053813</td>
<td>3 Buku</td>
<td class="status"><span class="badge badge-active">Aktif</span></td>
<td>
<button class="btn-detail">👁 Detail</button>
</td>
</tr>

<tr>
<td>3</td>
<td>Nela Fitria</td>
<td>X TKJ</td>
<td>0895335053813</td>
<td>0</td>
<td class="status"><span class="badge badge-inactive">Tidak Aktif</span></td>
<td>
<button class="btn-detail">👁 Detail</button>
</td>
</tr>

<tr>
<td>4</td>
<td>Dewi Sartika</td>
<td>XII RPL</td>
<td>0895335053813</td>
<td>2 Buku</td>
<td class="status"><span class="badge badge-inactive">Tidak Aktif</span></td>
<td>
<button class="btn-detail">👁 Detail</button>
</td>
</tr>

</tbody>

</table>
</div>

</div>
</div>

<script>

const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");
const table = document.getElementById("anggotaTable");
const rows = table.getElementsByTagName("tr");

function filterTable(){

let searchValue = searchInput.value.toLowerCase();
let statusValue = statusFilter.value.toLowerCase();

for(let i=1;i<rows.length;i++){

let nama = rows[i].cells[1].textContent.toLowerCase();
let status = rows[i].cells[5].textContent.toLowerCase();

let matchSearch = nama.includes(searchValue);
let matchStatus = statusValue === "" || status === statusValue;

if(matchSearch && matchStatus){
rows[i].style.display="";
}else{
rows[i].style.display="none";
}

}

}

searchInput.addEventListener("keyup",filterTable);
statusFilter.addEventListener("change",filterTable);

</script>

@endsection