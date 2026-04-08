@extends('layouts.backend.admin.app')

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
<h4>Tambah Anggota</h4>
<p>Tambahkan data siswa sebagai anggota perpustakaan</p>
</div>

<div class="card card-form">
<div class="card-body">

<form action="{{ route('admin.anggota.store') }}" method="POST">
@csrf

<div class="mb-3">
<label>Nama Siswa</label>
<input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>

@error('nama')
<div class="error-text">{{ $message }}</div>
@enderror
</div>

<div class="mb-3">
<label>NIS</label>
<input type="text" name="nis" value="{{ old('nis') }}" class="form-control" required>

@error('nis')
<div class="error-text">{{ $message }}</div>
@enderror
</div>

<div class="mb-3">
<label>Kelas</label>
<input type="text" name="kelas" value="{{ old('kelas') }}" class="form-control" required>

@error('kelas')
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

<a href="{{ route('admin.anggota.index') }}" class="btn-back">
Kembali
</a>

</div>

</form>

</div>
</div>

@endsection