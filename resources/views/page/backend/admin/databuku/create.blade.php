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
<h4>Tambah Buku</h4>
<p>Tambahkan buku baru ke dalam sistem perpustakaan</p>
</div>


<div class="card card-form">
<div class="card-body">

<form action="{{ route('admin.databuku.store') }}" method="POST" enctype="multipart/form-data">
@csrf


<div class="mb-3">
<label>Cover Buku</label>
<input type="file" name="photo" class="form-control">

@error('photo')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Judul Buku</label>
<input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>

@error('judul')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Penulis</label>
<input type="text" name="penulis" value="{{ old('penulis') }}" class="form-control" required>

@error('penulis')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Penerbit</label>
<input type="text" name="penerbit" value="{{ old('penerbit') }}" class="form-control" required>

@error('penerbit')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Kategori</label>
<input type="text" name="kategori" value="{{ old('kategori') }}" class="form-control" placeholder="">

@error('kategori')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" value="{{ old('stok') }}" class="form-control" required>

@error('stok')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="d-flex justify-content-end gap-2">

<button type="submit" class="btn-save">
 Simpan
</button>

<a href="{{ route('admin.databuku.index') }}" class="btn-back">
Kembali
</a>

</div>

</form>

</div>
</div>

@endsection