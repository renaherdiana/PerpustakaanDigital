@extends('layouts.backend.superadmin.app')

@section('content')

<style>

/* HEADER EDIT */
.header-edit{
background:linear-gradient(90deg,#eef7ff,#ffffff);
padding:18px 25px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.06);
margin-bottom:25px;
}

.header-edit h4{
margin:0;
font-weight:700;
color:#4f7cff;
}

.header-edit p{
margin:2px 0 0 0;
font-size:14px;
color:#777;
}

/* CARD FORM */
.card-form{
border:none;
border-radius:14px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
padding:30px;
}

/* PHOTO */
.photo-preview{
display:flex;
justify-content:center;
margin-bottom:20px;
}

.photo-preview img{
width:90px;
height:90px;
border-radius:50%;
object-fit:cover;
border:3px solid #f1f1f1;
}

/* INPUT */
.form-control{
border-radius:10px;
height:42px;
}

/* BUTTON */
.btn-update{
background:#4f7cff;
color:white;
border:none;
padding:10px 25px;
border-radius:8px;
font-weight:600;
}

.btn-cancel{
background:#e63946;
color:white;
border:none;
padding:10px 25px;
border-radius:8px;
font-weight:600;
text-decoration:none;
}

.btn-area{
display:flex;
justify-content:flex-end;
gap:10px;
margin-top:20px;
}

</style>


<div class="header-edit">
<h4>Edit Petugas</h4>
<p>Perbarui informasi petugas perpustakaan</p>
</div>


<div class="card card-form">
<div class="card-body">

<form action="{{ route('superadmin.datauser.update',$user->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')


<div class="photo-preview">

@if($user->photo)
<img src="{{ asset('storage/'.$user->photo) }}">
@else
<img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f7cff&color=fff&size=200">
@endif

</div>


<div class="mb-3">
<label>Foto Petugas</label>
<input type="file" name="photo" class="form-control">
</div>


<div class="mb-3">
<label>Nama Petugas</label>
<input type="text" name="name" class="form-control" value="{{ $user->name }}">
</div>


<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" value="{{ $user->email }}">
</div>


<div class="mb-3">
<label>No Telephone</label>
<input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
</div>


<div class="mb-3">
<label>Password (Opsional)</label>
<input type="password" name="password" class="form-control">
</div>


<div class="mb-3">
<label>Status</label>

<select name="status" class="form-control">

<option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>
Aktif
</option>

<option value="tidak_aktif" {{ $user->status == 'tidak_aktif' ? 'selected' : '' }}>
Tidak Aktif
</option>

</select>

</div>


<div class="btn-area">

<a href="{{ route('superadmin.datauser.index') }}" class="btn-cancel">
Batal
</a>

<button type="submit" class="btn-update">
Update
</button>

</div>


</form>

</div>
</div>

@endsection