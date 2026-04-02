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
flex:1;
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

/* ADD BUTTON */
.btn-add{
background:linear-gradient(135deg,#7c6cf3,#9f8cff);
color:white;
border:none;
border-radius:12px;
padding:8px 18px;
font-weight:500;
transition:0.2s;
}

.btn-add:hover{
opacity:0.9;
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

/* USER PHOTO */
.user-photo{
width:45px;
height:45px;
border-radius:50%;
object-fit:cover;
border:2px solid #f1f1ff;
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

/* ACTION BUTTONS */

.btn-sm{
border-radius:8px;
font-size:12px;
padding:5px 10px;
border:none;
}

/* EDIT */

.btn-edit{
background:#e0e7ff;
color:#3730a3;
}

.btn-edit:hover{
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

/* SHOW */

.btn-show{
background:#f1f5f9;
color:#334155;
}

.btn-show:hover{
background:#e2e8f0;
}

</style>

<div class="card card-custom">
<div class="card-body">

<h5 class="page-title">Kelola Data User</h5>

<!-- FILTER -->
<div class="filter-area">

<div class="filter-left">

<input type="text" placeholder="Cari Anggota...">

<select>
<option>Role</option>
<option>Admin</option>
<option>Petugas</option>
<option>Anggota</option>
</select>

</div>

<button class="btn-add">
+ Tambah User
</button>

</div>

<!-- TABLE -->
<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>
<th>No</th>
<th>Photo</th>
<th>Nama Anggota</th>
<th>No Telephone</th>
<th>Status</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<tr>
<td>1</td>
<td><img src="https://i.pravatar.cc/40" class="user-photo"></td>
<td>Rena Herdiana</td>
<td>0895335053813</td>
<td><span class="badge badge-active">Aktif</span></td>
<td>
<button class="btn btn-edit btn-sm">✏️ Edit</button>
<button class="btn btn-delete btn-sm">🗑 Delete</button>
<button class="btn btn-show btn-sm">👁 Show</button>
</td>
</tr>

<tr>
<td>2</td>
<td><img src="https://i.pravatar.cc/41" class="user-photo"></td>
<td>Virda Ainun Nazah</td>
<td>0895335053813</td>
<td><span class="badge badge-inactive">Tidak Aktif</span></td>
<td>
<button class="btn btn-edit btn-sm">✏️ Edit</button>
<button class="btn btn-delete btn-sm">🗑 Delete</button>
<button class="btn btn-show btn-sm">👁 Show</button>
</td>
</tr>

<tr>
<td>3</td>
<td><img src="https://i.pravatar.cc/42" class="user-photo"></td>
<td>Nela Fitria</td>
<td>0895335053813</td>
<td><span class="badge badge-inactive">Tidak Aktif</span></td>
<td>
<button class="btn btn-edit btn-sm">✏️ Edit</button>
<button class="btn btn-delete btn-sm">🗑 Delete</button>
<button class="btn btn-show btn-sm">👁 Show</button>
</td>
</tr>

</tbody>

</table>

</div>

</div>
</div>

@endsection