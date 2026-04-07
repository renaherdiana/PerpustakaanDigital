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
    <h4>Edit Anggota</h4>
    <p>Perbarui informasi anggota perpustakaan</p>
</div>

<div class="card card-form">
    <div class="card-body">

        <form action="{{ route('admin.anggota.update',$anggota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="photo-preview">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($anggota->nama) }}&background=4f7cff&color=fff&size=200">
            </div>

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ $anggota->nama }}">
            </div>

            <div class="mb-3">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control" value="{{ $anggota->nis }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $anggota->email }}">
            </div>

            <div class="mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ $anggota->kelas }}">
            </div>

            <div class="mb-3">
                <label>Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ $anggota->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ $anggota->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="btn-area">
                <a href="{{ route('admin.anggota.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-update">Update</button>
            </div>

        </form>

    </div>
</div>

@endsection