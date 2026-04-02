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

/* BADGE */

.badge{
padding:6px 12px;
border-radius:20px;
font-size:12px;
}

.badge-wait{
background:#fef3c7;
color:#92400e;
}

.badge-return{
background:#d1fae5;
color:#065f46;
}

/* BUTTON */

.btn-action{
border:none;
border-radius:8px;
font-size:12px;
padding:6px 10px;
display:inline-flex;
align-items:center;
gap:4px;
}

.btn-verify{
background:#dcfce7;
color:#166534;
cursor:pointer;
}

.btn-show{
background:#f1f5f9;
color:#334155;
text-decoration:none;
}

/* POPUP */

.popup-bg{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.4);
display:none;
align-items:center;
justify-content:center;
z-index:999;
}

.popup-box{
background:white;
width:420px;
border-radius:16px;
padding:25px;
box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.popup-title{
font-weight:700;
font-size:18px;
margin-bottom:15px;
text-align:center;
}

.popup-data{
display:flex;
justify-content:space-between;
border-bottom:1px solid #eee;
padding:8px 0;
font-size:14px;
}

.popup-status{
margin-top:12px;
padding:10px;
border-radius:8px;
font-weight:600;
}

.status-terlambat{
background:#fee2e2;
color:#b91c1c;
}

.status-tepat{
background:#dcfce7;
color:#166534;
}

.popup-denda{
margin-top:10px;
font-weight:700;
color:#b91c1c;
}

.popup-btn{
display:flex;
justify-content:flex-end;
gap:10px;
margin-top:18px;
}

.btn-batal{
background:#e5e7eb;
border:none;
padding:7px 16px;
border-radius:8px;
}

.btn-verif{
background:#22c55e;
border:none;
padding:7px 16px;
border-radius:8px;
color:white;
}

</style>


<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Data Pengembalian</h5>

<div class="filter-area">

<div class="filter-left">
<input type="text" id="searchInput" placeholder="Cari Anggota / Buku...">
</div>

</div>


<div class="table-responsive">

<table class="table align-middle" id="pengembalianTable">

<thead>
<tr>
<th>No</th>
<th>Nama Anggota</th>
<th>Judul Buku</th>
<th>Tgl Pinjam</th>
<th>Tgl Kembali</th>
<th>Tgl Dikembalikan</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse($pengembalian as $no => $data)

<tr>

<td>{{ $no+1 }}</td>

<td>{{ $data->peminjaman->nama_anggota }}</td>

<td>{{ optional($data->peminjaman->buku)->judul }}</td>

<td>{{ \Carbon\Carbon::parse($data->peminjaman->tgl_pinjam)->format('Y-m-d') }}</td>

<td>{{ \Carbon\Carbon::parse($data->peminjaman->tgl_kembali)->format('Y-m-d') }}</td>

<td>{{ \Carbon\Carbon::parse($data->tgl_dikembalikan)->format('Y-m-d') }}</td>

<td>

@if($data->status == 'menunggu_verifikasi')

<span class="badge badge-wait">
Menunggu Verifikasi
</span>

@else

<span class="badge badge-return">
Dikembalikan
</span>

@endif

</td>

<td>

@if($data->status == 'menunggu_verifikasi')

<button class="btn-action btn-verify"

onclick="openPopup(
'{{ $data->id }}',
'{{ $data->peminjaman->nama_anggota }}',
'{{ optional($data->peminjaman->buku)->judul }}',
'{{ $data->peminjaman->tgl_pinjam }}',
'{{ $data->peminjaman->tgl_kembali }}'
)"

>
✔ Verifikasi
</button>

@else

<a href="{{ route('admin.pengembalian.show',$data->id) }}" class="btn-action btn-show">
👁 Show
</a>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="8" style="text-align:center;padding:25px;">
Belum ada data pengembalian
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>
</div>


{{-- POPUP --}}

<div class="popup-bg" id="popupVerif">

<div class="popup-box">

<div class="popup-title">
Verifikasi Pengembalian
</div>

<div class="popup-data">
<span>Nama</span>
<span id="namaAnggota"></span>
</div>

<div class="popup-data">
<span>Buku</span>
<span id="judulBuku"></span>
</div>

<div class="popup-data">
<span>Tgl Pinjam</span>
<span id="tglPinjam"></span>
</div>

<div class="popup-data">
<span>Tgl Kembali</span>
<span id="tglKembali"></span>
</div>

<div id="statusInfo"></div>
<div id="dendaInfo"></div>

<form id="formVerif" method="POST">
@csrf

<div class="popup-btn">

<button type="button" class="btn-batal" onclick="closePopup()">
Batal
</button>

<button type="submit" class="btn-verif">
✔ Verifikasi
</button>

</div>

</form>

</div>
</div>


<script>

/* SEARCH */

const searchInput=document.getElementById("searchInput");
const table=document.getElementById("pengembalianTable");
const rows=table.getElementsByTagName("tr");

searchInput.addEventListener("keyup",function(){

const value=this.value.toLowerCase();

for(let i=1;i<rows.length;i++){

const anggota=rows[i].cells[1]?.textContent.toLowerCase();
const buku=rows[i].cells[2]?.textContent.toLowerCase();

if(anggota?.includes(value)||buku?.includes(value)){
rows[i].style.display="";
}else{
rows[i].style.display="none";
}

}

});


/* POPUP */

function openPopup(id,nama,judul,pinjam,kembali){

document.getElementById("popupVerif").style.display="flex";

document.getElementById("namaAnggota").innerText=nama;
document.getElementById("judulBuku").innerText=judul;
document.getElementById("tglPinjam").innerText=pinjam;
document.getElementById("tglKembali").innerText=kembali;

document.getElementById("formVerif").action="/admin/pengembalian/verifikasi/"+id;


let today=new Date();
let kembaliDate=new Date(kembali);

let diffTime=today-kembaliDate;
let diffDays=Math.floor(diffTime/(1000*60*60*24));

if(diffDays>0){

let denda=diffDays*1000;

document.getElementById("statusInfo").innerHTML=
"<div class='popup-status status-terlambat'>Terlambat "+diffDays+" hari</div>";

document.getElementById("dendaInfo").innerHTML=
"<div class='popup-denda'>Denda : Rp "+denda+"</div>";

}else{

document.getElementById("statusInfo").innerHTML=
"<div class='popup-status status-tepat'>Tepat Waktu</div>";

document.getElementById("dendaInfo").innerHTML="";

}

}

function closePopup(){
document.getElementById("popupVerif").style.display="none";
}

</script>

@endsection