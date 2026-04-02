@extends('layouts.frontend.app')

@section('content')

<style>

/* HERO SECTION */
.hero-section{
    position: relative;
    height: 600px;
    background-image: url("{{ asset('assetsfrontend/img/hero.jpg') }}");
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
}

/* OVERLAY */
.hero-overlay{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:#2f3353;
    opacity:0.85;
    z-index:1;
    pointer-events:none;
}

/* CONTENT */
.hero-content{
    position:absolute;
    left:120px;
    top:50%;
    transform:translateY(-50%);
    color:white;
    max-width:650px;
    z-index:3;
}

/* tulisan kecil */
.hero-content h5{
    font-size:22px;
    margin-bottom:10px;
}

/* judul besar */
.hero-title{
    font-size:48px;
    font-weight:700;
}

.hero-title span{
    color:#f5c26b;
}

/* deskripsi */
.hero-content p{
    font-size:18px;
    line-height:1.7;
    margin-top:15px;
}

/* tombol */
.btn-jelajah{
    background:#f5c26b;
    border:none;
    padding:12px 30px;
    border-radius:25px;
    color:white;
    margin-top:25px;
    font-size:16px;
    text-decoration:none;
    display:inline-block;
    transition:0.3s;
}

.btn-jelajah:hover{
    background:#e6b15e;
    transform:translateY(-2px);
    color:white;
    text-decoration:none;
}

/* WAVE */
.hero-wave{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    z-index:2;
    pointer-events:none;
}

/* RESPONSIVE */
@media (max-width:768px){

.hero-section{
    height:500px;
}

.hero-content{
    left:30px;
    right:30px;
}

.hero-title{
    font-size:36px;
}

}

</style>


<!-- HERO -->
<section class="hero-section">

<div class="hero-overlay"></div>

<div class="container hero-content">

<h5>Selamat Datang di</h5>

<h2 class="hero-title">
Perpustakaan Digital <span><br>SMKN 3 Banjar</span>
</h2>

<p>
Temukan dan pinjam buku favorit anda secara <br>
online dengan mudah dan cepat.
</p>

<a href="{{ route('katalog') }}" class="btn-jelajah">
Jelajahi Buku
</a>

</div>

<!-- WAVE -->
<svg class="hero-wave" viewBox="0 0 1440 200">
<path fill="#ffffff" fill-opacity="1"
d="M0,96L60,112C120,128,240,160,360,160C480,160,600,128,720,138.7C840,149,960,203,1080,202.7C1200,203,1320,149,1380,122.7L1440,96L1440,320L0,320Z">
</path>
</svg>

</section>


<!-- ABOUT -->
@include('page.frontend.home.about')

@endsection