@extends('layouts.backend.superadmin.app')

@section('content')

<style>

/* HEADER TAMBAH */
.header-create{
background:linear-gradient(90deg,#eef7ff,#ffffff);
padding:18px 25px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.06);
margin-bottom:25px;
}

.header-create h4{
margin:0;
font-weight:700;
color:#4f7cff;
}

.header-create p{
margin:2px 0 0 0;
font-size:14px;
color:#777;
}

/* CARD FORM */
.card-form{
border:none;
border-radius:14px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
padding:25px;
}

/* INPUT */
.form-control{
border-radius:10px;
height:42px;
}

/* BUTTON */
.btn-save{
background:#4f7cff;
color:white;
border:none;
padding:10px 20px;
border-radius:10px;
font-weight:600;
}

.btn-back{
background:#f1f5f9;
padding:10px 20px;
border-radius:10px;
text-decoration:none;
color:#333;
}

/* ERROR */
.error-text{
color:red;
font-size:13px;
margin-top:4px;
}

</style>


<div class="header-create">
<h4>Tambah Petugas</h4>
<p>Tambahkan data petugas perpustakaan</p>
</div>


<div class="card card-form">
<div class="card-body">

<form action="{{ route('superadmin.datauser.store') }}" method="POST" enctype="multipart/form-data">
@csrf


<div class="mb-3">
<label>Foto Petugas</label>
<input type="file" name="photo" class="form-control">
</div>


<div class="mb-3">
<label>Nama Petugas</label>
<input type="text" name="name" value="{{ old('name') }}" class="form-control" required>

@error('name')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" class="form-control" required>

@error('email')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>No Telephone</label>
<input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>

@error('phone')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>

@error('password')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Status</label>

<select name="status" class="form-control">
<option value="aktif">Aktif</option>
<option value="tidak_aktif">Tidak Aktif</option>
</select>

@error('status')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="d-flex justify-content-end gap-2">

<button type="submit" class="btn-save">
Simpan
</button>

<a href="{{ route('superadmin.datauser.index') }}" class="btn-back">
Kembali
</a>

</div>

</form>

</div>
</div>

@endsection