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

/* ADD BUTTON */
.btn-add{
background:linear-gradient(135deg,#7c6cf3,#9f8cff);
color:white;
border:none;
border-radius:12px;
padding:8px 18px;
font-weight:500;
text-decoration:none;
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

/* STATUS */
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

/* ACTION ICONS */
.action-icons{
display:flex;
gap:8px;
}

/* ICON BUTTON */
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


<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Kelola Data Petugas</h5>

<!-- BUTTON TAMBAH -->
<div class="filter-area">

<div></div>

<a href="{{ route('superadmin.datauser.create') }}" class="btn-add">
+ Tambah Petugas
</a>

</div>

<!-- TABLE -->
<div class="table-responsive">

<table class="table align-middle">

<thead>
<tr>
<th>No</th>
<th>Photo</th>
<th>Nama Petugas</th>
<th>No Telephone</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse ($users as $key => $user)

<tr>

<td>{{ $key + 1 }}</td>

<td>
@if($user->photo)
<img src="{{ asset('storage/'.$user->photo) }}" class="user-photo">
@else
<img src="https://i.pravatar.cc/45?img={{ $key+1 }}" class="user-photo">
@endif
</td>

<td>{{ $user->name }}</td>

<td>{{ $user->phone }}</td>

<td>
@if($user->status == 'aktif')
<span class="badge badge-active">Aktif</span>
@else
<span class="badge badge-inactive">Tidak Aktif</span>
@endif
</td>

<td>

<div class="action-icons">

<a href="{{ route('superadmin.datauser.edit',$user->id) }}" class="icon-btn icon-edit" title="Edit">
<i class="bi bi-pencil"></i>
</a>

<form action="{{ route('superadmin.datauser.destroy',$user->id) }}" method="POST">
@csrf
@method('DELETE')

<button class="icon-btn icon-delete" title="Hapus"
onclick="return confirm('Yakin hapus petugas?')">
<i class="bi bi-trash"></i>
</button>

</form>

<a href="{{ route('superadmin.datauser.show',$user->id) }}" class="icon-btn icon-show" title="Detail">
<i class="bi bi-eye"></i>
</a>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center">Data Petugas Belum Ada</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>
</div>

@endsection