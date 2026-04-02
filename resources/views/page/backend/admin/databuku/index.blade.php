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

/* BOOK COVER */
.book-cover{
width:45px;
height:60px;
object-fit:cover;
border-radius:6px;
border:2px solid #f1f1ff;
}

/* BADGE */
.badge{
padding:6px 12px;
border-radius:20px;
font-size:12px;
}

.badge-available{
background:#d1fae5;
color:#065f46;
}

.badge-empty{
background:#fee2e2;
color:#991b1b;
}

/* BUTTON TAMBAH */
.btn-add{
background:#4f7cff;
color:white;
border:none;
padding:10px 18px;
font-size:14px;
font-weight:600;
border-radius:10px;
display:flex;
align-items:center;
gap:6px;
text-decoration:none;
}

.btn-add:hover{
background:#3f6df0;
}

/* ACTION ICONS AESTHETIC */
.action-icons{
display:flex;
gap:8px;
}

.icon-btn{
width:34px;
height:34px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
font-size:16px;
border:none;
cursor:pointer;
text-decoration:none;
transition:0.2s;
}

/* EDIT */
.icon-edit{
background:#eef2ff;
color:#4f46e5;
}

.icon-edit:hover{
background:#4f46e5;
color:white;
}

/* DELETE */
.icon-delete{
background:#fee2e2;
color:#dc2626;
}

.icon-delete:hover{
background:#dc2626;
color:white;
}

/* DETAIL */
.icon-show{
background:#ecfdf5;
color:#059669;
}

.icon-show:hover{
background:#059669;
color:white;
}

</style>

@php
$kategoris = $bukus->pluck('kategori')->unique();
@endphp

<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Kelola Data Buku</h5>

<div class="filter-area">

<div class="filter-left">

<input type="text" id="searchInput" placeholder="Cari Judul Buku...">

<select id="kategoriFilter">
<option value="">Semua Kategori</option>

@foreach($kategoris as $kategori)

<option value="{{ $kategori }}">{{ $kategori }}</option>
@endforeach

</select>

</div>

<a href="{{ route('admin.databuku.create') }}" class="btn-add">
<i class="bi bi-plus-lg"></i> Tambah Buku
</a>

</div>

<div class="table-responsive">

<table class="table align-middle" id="bukuTable">

<thead>
<tr>
<th>No</th>
<th>Photo</th>
<th>Judul</th>
<th>Penulis</th>
<th>Kategori</th>
<th>Stok</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($bukus as $buku)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($buku->photo)
<img src="{{ asset('storage/'.$buku->photo) }}" class="book-cover">
@else
<img src="https://picsum.photos/60/90" class="book-cover">
@endif
</td>

<td>{{ $buku->judul }}</td>
<td>{{ $buku->penulis }}</td>
<td>{{ $buku->kategori }}</td>
<td>{{ $buku->stok }}</td>

<td>
@if($buku->status == 'Tersedia')
<span class="badge badge-available">Tersedia</span>
@else
<span class="badge badge-empty">Habis</span>
@endif
</td>

<td>

<div class="action-icons">

<a href="{{ route('admin.databuku.edit',$buku->id) }}" class="icon-btn icon-edit" title="Edit">
<i class="bi bi-pencil"></i>
</a>

<form action="{{ route('admin.databuku.destroy',$buku->id) }}" method="POST">
@csrf
@method('DELETE')

<button class="icon-btn icon-delete" title="Hapus"
onclick="return confirm('Yakin hapus buku?')"> <i class="bi bi-trash"></i> </button>

</form>

<a href="{{ route('admin.databuku.show',$buku->id) }}" class="icon-btn icon-show" title="Detail">
<i class="bi bi-eye"></i>
</a>

</div>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>
</div>

<script>

const searchInput = document.getElementById("searchInput");
const kategoriFilter = document.getElementById("kategoriFilter");
const table = document.getElementById("bukuTable");
const rows = table.getElementsByTagName("tr");

function filterTable(){

const searchValue = searchInput.value.toLowerCase();
const kategoriValue = kategoriFilter.value.toLowerCase();

for(let i=1;i<rows.length;i++){

const judul = rows[i].cells[2].textContent.toLowerCase();
const kategori = rows[i].cells[4].textContent.toLowerCase();

const matchSearch = judul.includes(searchValue);
const matchKategori = kategoriValue === "" || kategori.includes(kategoriValue);

if(matchSearch && matchKategori){
rows[i].style.display="";
}else{
rows[i].style.display="none";
}

}

}

searchInput.addEventListener("keyup",filterTable);
kategoriFilter.addEventListener("change",filterTable);

</script>

@endsection
