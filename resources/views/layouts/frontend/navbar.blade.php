<!-- ==========================
     NAVBAR FRONTEND ANGGOTA
=========================== -->
<style>
/* NAVBAR CUSTOM */
.navbar-custom {
    background: white;
    padding: 15px 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.logo-title {
    font-weight: 600;
    color: #2bb3c0;
    font-size: 18px;
    display: flex;
    align-items: center;
}

.logo-title img {
    margin-right: 10px;
}

.nav-link {
    color: #333;
    margin: 0 15px;
    font-weight: 500;
    transition: 0.2s;
}

/* HOVER */
.nav-link:hover {
    color: #2bb3c0;
}

/* ACTIVE MENU */
.nav-link.active {
    color: #2bb3c0;
    font-weight: 600;
    border-bottom: 2px solid #2bb3c0;
}

.btn-login {
    background: #2bb3c0;
    color: white;
    border-radius: 20px;
    padding: 6px 20px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-login:hover {
    background: #239aa5;
    color: white;
}

.user-dropdown {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-weight: 500;
    color: #2bb3c0;
    background: #f0fbfc;
    border: 1.5px solid #2bb3c0;
    border-radius: 25px;
    padding: 5px 14px 5px 8px;
    transition: 0.2s;
}

.user-dropdown:hover {
    background: #e0f7f9;
}

.user-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #2bb3c0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.dropdown-menu {
    position: absolute;
    right: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    padding: 10px 0;
    display: none;
    min-width: 160px;
    z-index: 1000;
}

.dropdown-menu a {
    display: block;
    padding: 8px 20px;
    color: #333;
    text-decoration: none;
    transition: 0.2s;
}

.dropdown-menu a:hover {
    background: #f3f4f6;
    color: #2bb3c0;
}

.dropdown-show {
    display: block;
}
</style>

<nav class="navbar navbar-expand-lg navbar-custom">
<div class="container">

    <!-- Logo -->
    <a class="navbar-brand logo-title" href="{{ route('home') }}">
        <img src="{{ asset('assetsfrontend/img/perpustakaan.png') }}" width="40">
        E-Library SMKN 3 Banjar
    </a>

    <!-- Toggle for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarMenu">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('katalog') ? 'active' : '' }}" href="{{ route('katalog') }}">Katalog Buku</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peminjamansaya') ? 'active' : '' }}" href="{{ route('peminjamansaya') }}">Peminjaman Saya</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('frontend.denda') ? 'active' : '' }}" href="{{ route('frontend.denda') }}">Denda</a>
            </li>
        </ul>
    </div>

    <!-- LOGIN / USER -->
    <div class="ms-auto">
    @if(session('anggota_id'))
        <div class="user-dropdown" onclick="document.getElementById('dropdownMenu').classList.toggle('dropdown-show')">
            <div class="user-icon">👤</div>
            <span>Halo, <strong>{{ session('anggota_nama') }}</strong></span>
            <span style="font-size:11px; opacity:0.6;">▼</span>
        </div>
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="#">Profile Saya</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a>
        </div>
        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}" class="btn-login">Login</a>
    @endif
    </div>

</div>
</nav>

<script>
// Dropdown toggle & close klik di luar
document.addEventListener('click', function(event){
    const dropdown = document.getElementById('dropdownMenu');
    const toggle = document.querySelector('.user-dropdown');

    if(toggle && toggle.contains(event.target)){
        // klik dropdown → handled via onclick
    } else if(dropdown && !dropdown.contains(event.target)){
        dropdown.classList.remove('dropdown-show');
    }
});
</script>