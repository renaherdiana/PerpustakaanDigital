@extends('layouts.frontend.app')

@section('content')

<style>
.header-page{
    background:#4a4e69;
    color:white;
    padding:70px 0;
    text-align:center;
    margin-bottom:0;
}

.edit-wrapper {
    background: #f4f6fb;
    padding: 40px 20px 70px;
    display: flex;
    justify-content: center;
}

.edit-outer {
    width: 100%;
    max-width: 780px;
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    overflow: hidden;
    display: flex;
}

/* KIRI — profile info */
.edit-left {
    width: 240px;
    flex-shrink: 0;
    background: linear-gradient(160deg, #2bb3c0 0%, #4a4e6d 100%);
    padding: 40px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
}



.avatar-ring {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 3px solid rgba(255,255,255,0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin-bottom: 14px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.edit-left h5 {
    color: white;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 6px;
}

.kelas-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: white;
    font-size: 11px;
    padding: 3px 12px;
    border-radius: 20px;
    margin-bottom: 24px;
}

.side-info {
    width: 100%;
    text-align: left;
}

.side-item {
    margin-bottom: 16px;
}

.side-label {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.side-value {
    font-size: 13px;
    color: white;
    font-weight: 500;
    word-break: break-all;
}

.badge-aktif {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: #a8ffd4;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-tidak_aktif {
    display: inline-block;
    background: rgba(255,100,100,0.25);
    color: #ffb3b3;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

/* KANAN — form */
.edit-right {
    flex: 1;
    padding: 36px 32px;
    overflow-y: auto;
}

.edit-right h4 {
    font-size: 18px;
    font-weight: 700;
    color: #2c2c2c;
    margin-bottom: 6px;
}

.edit-right .sub {
    font-size: 13px;
    color: #aaa;
    margin-bottom: 24px;
}

.section-label {
    font-size: 11px;
    font-weight: 700;
    color: #bbb;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 14px;
}

.form-group { margin-bottom: 16px; }

.form-group label {
    font-size: 12px;
    font-weight: 600;
    color: #666;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1.5px solid #e8e8e8;
    font-size: 14px;
    transition: 0.2s;
    box-sizing: border-box;
    background: #fafafa;
}

.form-control:focus {
    outline: none;
    border-color: #2bb3c0;
    box-shadow: 0 0 0 3px rgba(43,179,192,0.12);
    background: white;
}

.form-control[readonly] {
    background: #f2f2f2;
    color: #aaa;
    cursor: not-allowed;
    border-color: #ebebeb;
}

.divider {
    border: none;
    border-top: 1px dashed #ebebeb;
    margin: 22px 0;
}

.btn-group-edit {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 20px;
}

.btn-batal {
    padding: 10px 22px;
    border-radius: 25px;
    border: 1.5px solid #ddd;
    background: white;
    color: #888;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
    transition: 0.2s;
}

.btn-batal:hover { background: #f5f5f5; color: #444; }

.btn-simpan {
    padding: 10px 26px;
    border-radius: 25px;
    border: none;
    background: linear-gradient(135deg, #2bb3c0, #4a4e6d);
    color: white;
    font-weight: 600;
    cursor: pointer;
    font-size: 13px;
    transition: 0.3s;
    box-shadow: 0 6px 18px rgba(43,179,192,0.3);
}

.btn-simpan:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(43,179,192,0.4);
}

.alert-success {
    background: #e6f9f0;
    color: #1a9e5c;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 18px;
}

.text-danger { color: #e74c3c; font-size: 11px; margin-top: 3px; display: block; }

@media(max-width: 640px) {
    .edit-outer { flex-direction: column; }
    .edit-left { width: 100%; border-radius: 0; }
    .edit-left::after { display: none; }
    .edit-right { padding: 24px 20px; }
}
</style>

<div class="header-page">
    <h2>Edit Profile</h2>
    <div style="font-size:14px; opacity:0.8; margin-top:6px;">Home / Profile / Edit</div>
</div>

<div class="edit-wrapper">
    <div class="edit-outer">

        <!-- KIRI -->
        <div class="edit-left">
            <div class="avatar-ring">🎓</div>
            <h5>{{ $anggota->nama }}</h5>
            <span class="kelas-badge">{{ $anggota->kelas }}</span>

            <div class="side-info">
                <div class="side-item">
                    <div class="side-label">NIS</div>
                    <div class="side-value">{{ $anggota->nis }}</div>
                </div>
                <div class="side-item">
                    <div class="side-label">Email</div>
                    <div class="side-value">{{ $anggota->email }}</div>
                </div>
                <div class="side-item">
                    <div class="side-label">Status</div>
                    <div class="side-value">
                        <span class="badge-{{ $anggota->status }}">
                            {{ ucfirst(str_replace('_', ' ', $anggota->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN -->
        <div class="edit-right">

            <h4>Edit Profile</h4>
            <p class="sub">Perbarui informasi akun kamu</p>

            @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="section-label">Informasi Akun</div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="{{ $anggota->nama }}" readonly>
                </div>

                <div class="form-group">
                    <label>NIS</label>
                    <input type="text" class="form-control" value="{{ $anggota->nis }}" readonly>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" class="form-control" value="{{ $anggota->kelas }}" readonly>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $anggota->email) }}">
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <hr class="divider">

                <div class="section-label">Ganti Password &nbsp;<span style="font-weight:400;color:#ccc;">(opsional)</span></div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>

                <div class="btn-group-edit">
                    <a href="{{ route('anggota.profile') }}" class="btn-batal">Batal</a>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
