<style>

/* SECTION */
.about-section{
    padding:90px 0;
    background:linear-gradient(180deg,#fafafa,#ffffff);
}

/* BOX */
.about-box{
    background:#ffffff;
    padding:70px;
    border-radius:20px;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
    position:relative;
    overflow:hidden;
}

/* decorative circle */
.about-box::before{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    background:#f5c26b20;
    border-radius:50%;
    top:-60px;
    right:-60px;
}

.about-box::after{
    content:"";
    position:absolute;
    width:120px;
    height:120px;
    background:#4a4e6920;
    border-radius:50%;
    bottom:-40px;
    left:-40px;
}

/* TITLE */
.about-title{
    text-align:center;
    font-size:36px;
    font-weight:bold;
    margin-bottom:10px;
    font-family:serif;
    letter-spacing:1px;
}

.about-title span{
    color:#f5c26b;
}

/* DIVIDER */
.title-divider{
    width:120px;
    height:3px;
    background:#f5c26b;
    margin:15px auto 5px auto;
    border-radius:10px;
}

.title-divider-small{
    width:60px;
    height:2px;
    background:#ddd;
    margin:5px auto 50px auto;
}

/* LAYOUT */
.about-container{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:70px;
    flex-wrap:wrap;
}

/* IMAGE */
.about-image{
    position:relative;
}

.about-image img{
    width:270px;
    border-radius:15px;
    box-shadow:0 12px 25px rgba(0,0,0,0.15);
    transition:0.3s;
}

.about-image img:hover{
    transform:scale(1.05);
}

/* TEXT */
.about-text{
    max-width:520px;
    color:#666;
    line-height:1.9;
    font-size:16px;
}

/* highlight line beside text */
.about-text p{
    position:relative;
    padding-left:18px;
}

.about-text p::before{
    content:"";
    position:absolute;
    left:0;
    top:8px;
    width:6px;
    height:6px;
    background:#f5c26b;
    border-radius:50%;
}

/* RESPONSIVE */
@media (max-width:768px){

.about-container{
    flex-direction:column;
    text-align:center;
}

.about-image img{
    width:210px;
}

.about-box{
    padding:45px 25px;
}

}

</style>


<section class="about-section">

<div class="container">

<div class="about-box">

<h2 class="about-title">
Tentang <span>Perpustakaan</span>
</h2>

<div class="title-divider"></div>
<div class="title-divider-small"></div>

<div class="about-container">

<div class="about-image">
<img src="{{ asset('assetsfrontend/img/about.jpg') }}" alt="Perpustakaan">
</div>

<div class="about-text">
<p>
Perpustakaan Digital SMKN 3 Banjar dikembangkan sebagai sarana layanan
informasi dan literasi berbasis teknologi yang mendukung proses
pembelajaran di lingkungan sekolah.
</p>

<p>
Sistem ini dirancang untuk meningkatkan kemudahan akses, efisiensi
layanan, serta optimalisasi pengelolaan koleksi buku secara digital.
</p>
</div>

</div>

</div>

</div>

</section>