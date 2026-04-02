@extends('layouts.backend.admin.app')

@section('content')

<style>

.page-title{
font-weight:600;
font-size:18px;
margin-bottom:18px;
color:#334155;
}

/* CARD */

.card-custom{
border:none;
border-radius:10px;
box-shadow:0 4px 14px rgba(0,0,0,0.04);
padding:18px;
background:white;
}

/* FILTER */

.filter-area{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.filter-left{
display:flex;
gap:10px;
}

.filter-left input,
.filter-left select{
padding:6px 10px;
border-radius:6px;
border:1px solid #e2e8f0;
font-size:13px;
}

/* TABLE */

.table{
font-size:13px;
}

.table thead{
background:#f8fafc;
}

.table th{
font-weight:600;
color:#475569;
}

.table td{
vertical-align:middle;
}

.table tbody tr:hover{
background:#f8fafc;
}

/* BADGE */

.badge{
padding:4px 9px;
border-radius:14px;
font-size:11px;
}

.badge-wait{
background:#fef3c7;
color:#92400e;
}

.badge-borrow{
background:#dbeafe;
color:#1e40af;
}

.badge-done{
background:#d1fae5;
color:#065f46;
}

.badge-danger{
background:#fee2e2;
color:#b91c1c;
}

/* BUTTON */

.btn-action{
border:none;
border-radius:6px;
font-size:12px;
padding:4px 8px;
text-decoration:none;
}

.btn-approve{
background:#dcfce7;
color:#166534;
}

.btn-reject{
background:#fee2e2;
color:#b91c1c;
}

.btn-show{
background:#f1f5f9;
color:#334155;
}

/* PAGINATION */

.pagination{
gap:4px;
}

.pagination .page-link{
border:none;
background:#f1f5f9;
color:#334155;
font-size:12px;
padding:4px 9px;
border-radius:6px;
}

.pagination .page-link:hover{
background:#e2e8f0;
}

.pagination .active .page-link{
background:#3b82f6;
color:white;
}

</style>

<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Data Peminjaman</h5>

<div class="filter-area">

<div class="filter-left">

<input type="text" id="searchInput" placeholder="Cari...">

<select id="statusFilter">
<option value="">Semua</option>
<option value="menunggu">Menunggu</option>
<option value="dipinjam">Dipinjam</option>
<option value="terlambat">Terlambat</option>
<option value="selesai">Selesai</option>
<option value="selesai">Menunggu Verifikasi</option>
<option value="ditolak">Ditolak</option>
</select>

</div>

</div>

<div class="table-responsive">

<table class="table align-middle" id="peminjamanTable">

<thead>
<tr>
<th>No</th>
<th>Anggota</th>
<th>Buku</th>
<th>Tgl Pinjam</th>
<th>Tgl Kembali</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse($peminjamans as $no => $p)

<tr>

<td>{{ $peminjamans->firstItem() + $no }}</td>
<td>{{ $p->nama_anggota }}</td>

<td>{{ optional($p->buku)->judul }}</td>

<td>{{ $p->tgl_pinjam }}</td>
<td>{{ $p->tgl_kembali }}</td>

<td>

@if($p->status == 'menunggu') 
<span class="badge badge-wait">Menunggu</span>

@elseif($p->status == 'dipinjam') 
<span class="badge badge-borrow">Dipinjam</span>

@elseif($p->status == 'terlambat') 
<span class="badge badge-danger">Terlambat</span>

@elseif($p->status == 'selesai') 
<span class="badge badge-done">Selesai</span>

@elseif($p->status == 'menunggu_verifikasi')
<span class="badge bg-secondary">Menunggu Verifikasi</span>

@elseif($p->status == 'ditolak') 
<span class="badge badge-danger">Ditolak</span>

@endif

</td>

<td>

@if($p->status == 'menunggu')

<form action="{{ route('admin.peminjaman.update',$p->id) }}" method="POST" style="display:inline;">
@csrf
@method('PUT')

<input type="hidden" name="status" value="dipinjam">

<button class="btn-action btn-approve">✔</button>

</form>

<form action="{{ route('admin.peminjaman.update',$p->id) }}" method="POST" style="display:inline;">
@csrf
@method('PUT')

<input type="hidden" name="status" value="ditolak">

<button class="btn-action btn-reject">✖</button>

</form>

@else

<a href="{{ route('admin.peminjaman.show',$p->id) }}" class="btn-action btn-show">
👁
</a>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="7" style="text-align:center;padding:20px;">
Belum ada data
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="d-flex justify-content-between align-items-center mt-3">

<div style="font-size:12px;color:#64748b;">
{{ $peminjamans->firstItem() }}-{{ $peminjamans->lastItem() }} dari {{ $peminjamans->total() }}
</div>

<div>
{{ $peminjamans->links() }}
</div>

</div>

</div>
</div>

<script>

const searchInput=document.getElementById("searchInput");
const statusFilter=document.getElementById("statusFilter");
const table=document.getElementById("peminjamanTable");
const rows=table.getElementsByTagName("tr");

searchInput.addEventListener("keyup",filterTable);
statusFilter.addEventListener("change",filterTable);

function filterTable(){

const searchValue=searchInput.value.toLowerCase();
const statusValue=statusFilter.value.toLowerCase();

for(let i=1;i<rows.length;i++){

const anggota=rows[i].cells[1]?.textContent.toLowerCase();
const buku=rows[i].cells[2]?.textContent.toLowerCase();
const status=rows[i].cells[5]?.textContent.toLowerCase();

const cocokSearch=anggota?.includes(searchValue)||buku?.includes(searchValue);
const cocokStatus=statusValue===""||status?.includes(statusValue);

if(cocokSearch&&cocokStatus){
rows[i].style.display="";
}else{
rows[i].style.display="none";
}

}

}

</script>

@endsection