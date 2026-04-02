@extends('layouts.backend.admin.app')

@section('content')

<style>

.page-title{
font-weight:700;
font-size:20px;
margin-bottom:25px;
color:#3b3b3b;
}

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

.filter-left input{
min-width:250px;
padding:8px 12px;
border-radius:10px;
border:1px solid #e0e0e0;
font-size:14px;
}

.filter-left select{
padding:8px 12px;
border-radius:10px;
border:1px solid #e0e0e0;
font-size:14px;
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

/* PHOTO */
.user-photo{
width:45px;
height:45px;
border-radius:50%;
object-fit:cover;
border:2px solid #f1f1ff;
}

/* BADGE */
.badge{
padding:6px 12px;
border-radius:20px;
font-size:12px;
}

.badge-active{
background:#d1fae5;
color:#065f46;
}

.badge-inactive{
background:#fee2e2;
color:#991b1b;
}

.badge-pending{
background:#fef3c7;
color:#92400e;
}

/* ACTION BUTTON */
.btn-action{
border:none;
border-radius:8px;
font-size:12px;
padding:6px 10px;
display:inline-flex;
align-items:center;
gap:4px;
}

/* soft colors */
.btn-edit{
background:#e0e7ff;
color:#3730a3;
}

.btn-delete{
background:#fee2e2;
color:#b91c1c;
}

.btn-show{
background:#f1f5f9;
color:#334155;
}

.btn-verify{
background:#dcfce7;
color:#166534;
}

</style>

<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Kelola Data Anggota</h5>

<!-- SEARCH + FILTER -->
<div class="filter-area">

<div class="filter-left">

<input type="text" id="searchInput" placeholder="Cari Anggota...">

<select id="kelasFilter">
<option value="">Semua Kelas</option>
<option>XI RPL 1</option>
<option>X TKJ 2</option>
<option>X RPL 1</option>
</select>

</div>

</div>

<div class="table-responsive">

<table class="table align-middle" id="anggotaTable">

<thead>
<tr>
<th>No</th>
<th>Photo</th>
<th>Nama</th>
<th>Kelas</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<tr>
<td>1</td>
<td><img src="https://i.pravatar.cc/40" class="user-photo"></td>
<td>Rena Herdiana</td>
<td>XI RPL 1</td>
<td class="status">
<span class="badge badge-active">Aktif</span>
</td>
<td>
<button class="btn-action btn-edit">✏️ Edit</button>
<button class="btn-action btn-delete">🗑 Delete</button>
<button class="btn-action btn-show">👁 Show</button>
</td>
</tr>

<tr>
<td>2</td>
<td><img src="https://i.pravatar.cc/41" class="user-photo"></td>
<td>Virda Ainun</td>
<td>X TKJ 2</td>
<td class="status">
<span class="badge badge-inactive">Tidak Aktif</span>
</td>
<td>
<button class="btn-action btn-edit">✏️ Edit</button>
<button class="btn-action btn-delete">🗑 Delete</button>
<button class="btn-action btn-show">👁 Show</button>
</td>
</tr>

<tr>
<td>3</td>
<td><img src="https://i.pravatar.cc/42" class="user-photo"></td>
<td>Aldi Saputra</td>
<td>X RPL 1</td>
<td class="status">
<span class="badge badge-pending">Pending</span>
</td>
<td class="action">
<button class="btn-action btn-verify verifyBtn">✔ Verifikasi</button>
</td>
</tr>

</tbody>

</table>

</div>
</div>
</div>

<script>

/* =========================
VERIFIKASI STATUS
========================= */

const verifyButtons = document.querySelectorAll(".verifyBtn");

verifyButtons.forEach(function(button){

button.addEventListener("click",function(){

const row = this.closest("tr");

const statusCell = row.querySelector(".status");

const actionCell = row.querySelector(".action");

statusCell.innerHTML = '<span class="badge badge-active">Aktif</span>';

actionCell.innerHTML = `
<button class="btn-action btn-edit">✏️ Edit</button>
<button class="btn-action btn-delete">🗑 Delete</button>
<button class="btn-action btn-show">👁 Show</button>
`;

});

});


/* =========================
SEARCH + FILTER
========================= */

const searchInput = document.getElementById("searchInput");
const kelasFilter = document.getElementById("kelasFilter");
const table = document.getElementById("anggotaTable");
const rows = table.getElementsByTagName("tr");

function filterTable(){

const searchValue = searchInput.value.toLowerCase();
const kelasValue = kelasFilter.value.toLowerCase();

for(let i=1;i<rows.length;i++){

const nama = rows[i].cells[2].textContent.toLowerCase();
const kelas = rows[i].cells[3].textContent.toLowerCase();

const matchSearch = nama.includes(searchValue);
const matchKelas = kelasValue === "" || kelas.includes(kelasValue);

if(matchSearch && matchKelas){
rows[i].style.display="";
}else{
rows[i].style.display="none";
}

}

}

searchInput.addEventListener("keyup",filterTable);
kelasFilter.addEventListener("change",filterTable);

</script>

@endsection