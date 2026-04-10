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

.profile-wrapper {
    background: #f4f6fb;
    padding: 40px 20px 70px;
    display: flex;
    justify-content: center;
}

.profile-outer {
    width: 100%;
    max-width: 700px;
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    overflow: hidden;
    display: flex;
}

/* KIRI */
.profile-left {
    width: 220px;
    flex-shrink: 0;
    background: linear-gradient(160deg, #2bb3c0 0%, #4a4e6d 100%);
    padding: 40px 20px;
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

.profile-left h5 {
    color: white;
    font-size: 15px;
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
}

/* KANAN */
.profile-right {
    flex: 1;
    padding: 36px 30px;
    display: flex;
    flex-direction: column;
}

.profile-right h4 {
    font-size: 17px;
    font-weight: 700;
    color: #2c2c2c;
    margin-bottom: 4px;
}

.profile-right .sub {
    font-size: 12px;
    color: #bbb;
    margin-bottom: 22px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f2f5;
}

.info-item:last-of-type { border-bottom: none; }

.info-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.icon-teal   { background: #e8f9fb; }
.icon-blue   { background: #e8f0fe; }
.icon-purple { background: #f0eeff; }
.icon-green  { background: #e6f9f0; }

.info-label {
    font-size: 11px;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.info-value {
    font-size: 14px;
    font-weight: 600;
    color: #2c2c2c;
}

.badge-aktif {
    display: inline-block;
    background: #e6f9f0;
    color: #1a9e5c;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-tidak_aktif {
    display: inline-block;
    background: #fdecea;
    color: #d93025;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-edit-profile {
    display: inline-block;
    margin-top: 22px;
    align-self: flex-end;
    padding: 10px 26px;
    border-radius: 25px;
    background: linear-gradient(135deg, #2bb3c0, #4a4e6d);
    color: white;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 6px 18px rgba(43,179,192,0.3);
}

.btn-edit-profile:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(43,179,192,0.4);
    color: white;
}

@if(session('success'))
.alert-success {
    background: #e6f9f0;
    color: #1a9e5c;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 16px;
}
@endif

@media(max-width: 600px) {
    .profile-outer { flex-direction: column; }
    .profile-left { width: 100%; }
    .profile-left::after { display: none; }
    .profile-right { padding: 24px 20px; }
    .btn-edit-profile { align-self: stretch; text-align: center; }
}
</style>

<div class="header-page">
    <h2>Profile Saya</h2>
    <div style="font-size:14px; opacity:0.8; margin-top:6px;">Home / Profile</div>
</div>

<div class="profile-wrapper">
    <div class="profile-outer">

        <!-- KIRI -->
        <div class="profile-left">
            <div class="avatar-ring">🎓</div>
            <h5>{{ $anggota->nama }}</h5>
            <span class="kelas-badge">{{ $anggota->kelas }}</span>
        </div>

        <!-- KANAN -->
        <div class="profile-right">

            <h4>Profile Saya</h4>
            <p class="sub">Informasi akun kamu</p>

            @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            <div class="info-item">
                <div class="info-icon-box icon-teal">🪪</div>
                <div>
                    <div class="info-label">NIS</div>
                    <div class="info-value">{{ $anggota->nis }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon-box icon-blue">✉️</div>
                <div>
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $anggota->email }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon-box icon-purple">🏫</div>
                <div>
                    <div class="info-label">Kelas</div>
                    <div class="info-value">{{ $anggota->kelas }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon-box icon-green">✅</div>
                <div>
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge-{{ $anggota->status }}">
                            {{ ucfirst(str_replace('_', ' ', $anggota->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">✏️ &nbsp;Edit Profile</a>

        </div>
    </div>
</div>

@endsection
