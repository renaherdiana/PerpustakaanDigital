<style>

.navbar-custom{
    background: white;
    padding: 15px 0;
}

.logo-title{
    font-weight: 600;
    color: #2bb3c0;
    font-size: 18px;
    display:flex;
    align-items:center;
}

.logo-title img{
    margin-right:10px;
}

.nav-link{
    color:#333;
    margin:0 15px;
    font-weight:500;
}

/* HOVER */
.nav-link:hover{
    color:#2bb3c0;
}

/* ACTIVE MENU */
.nav-link.active{
    color:#2bb3c0;
    font-weight:600;
    border-bottom:2px solid #2bb3c0;
}

.btn-login{
    background:#2bb3c0;
    color:white;
    border-radius:20px;
    padding:6px 20px;
    text-decoration:none;
}

.btn-login:hover{
    background:#239aa5;
    color:white;
}

</style>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom">
<div class="container">

<!-- Logo -->
<a class="navbar-brand logo-title" href="{{ route('home') }}">
<img src="{{ asset('assetsfrontend/img/perpustakaan.png') }}" width="40">
E-Library SMKN 3 Banjar
</a>

<!-- Menu -->
<div class="collapse navbar-collapse justify-content-center">
<ul class="navbar-nav">

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('katalog') ? 'active' : '' }}" href="{{ route('katalog') }}">Katalog Buku</a></li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('peminjamansaya') ? 'active' : '' }}" href="{{ route('peminjamansaya') }}">Peminjaman Saya</a></li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('frontend.denda') ? 'active' : '' }}" href="{{ route('frontend.denda') }}">Denda</a></li>

</ul>
</div>

<!-- Login -->
<a href="#" class="btn-login">Login</a>

</div>
</nav>