@extends('layouts.backend.superadmin.app')

@section('content')

@php
    $user = Auth::guard('web')->user(); // Ambil data superadmin yang login
    $foto = $user->photo ? asset('storage/'.$user->photo) : 'https://i.pravatar.cc/150';
@endphp

<div class="container mt-4" style="max-width:700px;">
    <div class="card shadow-sm rounded-4 p-4">

        <h4 class="mb-4 text-center">Edit Profil Saya</h4>

        <form action="{{ route('superadmin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- FOTO -->
            <div class="text-center mb-4">
                <img src="{{ $foto }}" id="previewFoto" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover; border:3px solid #f59e0b;">
                <div class="mb-3">
                    <label for="photo" class="form-label">Ganti Foto Profil</label>
                    <input type="file" name="photo" id="photo" class="form-control" onchange="previewImage(event)">
                </div>
            </div>

            <!-- DATA -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>

            <!-- PASSWORD (OPTIONAL) -->
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin diganti)</small></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Isi jika ingin mengganti password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning px-4"> Simpan Perubahan</button>
            </div>

        </form>

    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('previewFoto');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<style>
.form-control {
    border-radius: 10px;
}
</style>

@endsection