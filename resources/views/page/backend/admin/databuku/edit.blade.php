@extends('layouts.backend.admin.app')

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
margin-bottom:25px;
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
<h4>Edit Buku</h4>
<p>Perbarui informasi buku dalam sistem</p>
</div>


<div class="card card-form">
<div class="card-body">

<form action="{{ route('admin.databuku.update',$buku->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')


<div class="photo-preview">

@if($buku->photo)
<img src="{{ asset('storage/'.$buku->photo) }}">
@else
<img src="https://picsum.photos/100">
@endif

</div>


<div class="mb-3">
<label>Photo</label>
<input type="file" name="photo" class="form-control">
</div>


<div class="mb-3">
<label>Judul</label>
<input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}">

@error('judul')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="mb-3">
<label>Penulis</label>
<input type="text" name="penulis" class="form-control" value="{{ $buku->penulis }}">
</div>


<div class="mb-3">
<label>Penerbit</label>
<input type="text" name="penerbit" class="form-control" value="{{ $buku->penerbit }}">
</div>


<div class="mb-3">
<label>Kategori</label>
<input type="text" name="kategori" class="form-control" value="{{ $buku->kategori }}">
</div>


<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" class="form-control" value="{{ $buku->stok }}" min="0">

@error('stok')
<div class="error-text">{{ $message }}</div>
@enderror
</div>


<div class="btn-area">

<a href="{{ route('admin.databuku.index') }}" class="btn-cancel">
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