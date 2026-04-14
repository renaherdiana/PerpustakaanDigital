<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.footer-top{
    background:#ffffff;
    padding:60px 0 25px 0;
    font-family:Arial, sans-serif;
}

/* gambar kiri */
.footer-logo img{
    width:170px;
}

/* judul */
.footer-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:18px;
    color:#2f3353;
}

/* text */
.footer-text{
    font-size:16px;
    color:#555;
    line-height:1.8;
    margin-bottom:15px;
}

.footer-text span{
    color:#f4a825;
    font-weight:600;
}

/* list */
.footer-list{
    list-style:none;
    padding:0;
}

.footer-list li{
    font-size:15px;
    color:#555;
    margin-bottom:12px;
    display:flex;
    align-items:flex-start;
    gap:10px;
}

.footer-list i{
    color:#f4a825;
    font-size:16px;
    margin-top:3px;
    flex-shrink:0;
}

/* wave */
.footer-wave{
    width:100%;
    display:block;
}

/* bawah */
.footer-bottom{
    background:#3f435f;
    color:white;
    text-align:center;
    padding:18px 0;
    font-size:14px;
}

.footer-col{
    margin-top:30px;
}

</style>


<footer>

<div class="footer-top">
<div class="container">
<div class="row">

<!-- Kolom kiri -->
<div class="col-md-4 footer-logo">
<p class="footer-text">
Mari tingkatkan literasi digital bersama<br>
<span>E-Library SMKN 3 Banjar</span>
</p>

<img src="{{ asset('assetsfrontend/img/bukufooter.png') }}">
</div>


<!-- Follow Us -->
<div class="col-md-3 footer-col"><br><br><br>

<h6 class="footer-title">Follow Us</h6>

<ul class="footer-list">
<li><i class="fa-brands fa-instagram"></i> Instagram : @elib_smkn3banjar</li>
<li><i class="fa-brands fa-tiktok"></i> TikTok : @elib_smkn3banjar</li>
<li><i class="fa-brands fa-twitter"></i> Twitter : @elib_smkn3banjar</li>
<li><i class="fa-brands fa-facebook"></i> Facebook : E-Library SMKN 3 Banjar</li>
</ul>

</div>


<!-- Get In Touch -->
<div class="col-md-3 footer-col"><br><br><br>

<h6 class="footer-title">Get In Touch</h6>

<ul class="footer-list">
<li><i class="fa-solid fa-location-dot"></i> Jl, Julaeni RT 05/ RW 02, Desa Langensari, Kec Langensari, Kota Banjar</li>
<li><i class="fa-solid fa-envelope"></i> librarysmkn3banjar@gmail.com</li>
<li><i class="fa-solid fa-phone"></i> +62 895335053813</li>
</ul>

</div>


<!-- Opening Hours -->
<div class="col-md-2 footer-col"><br><br><br>

<h6 class="footer-title">Opening Hours</h6>

<ul class="footer-list">
<li>Monday – Friday</li>
<li>07:00 AM – 03:00 PM</li>
<li style="color:red;">Saturday Closed</li>
</ul>

</div>

</div>
</div>


<!-- Wave -->
<svg class="footer-wave" viewBox="0 0 1440 200">
<path fill="#3f435f"
d="M0,160L80,154.7C160,149,320,139,480,122.7C640,107,800,85,960,96C1120,107,1280,149,1360,170.7L1440,192L1440,320L0,320Z">
</path>
</svg>


<div class="footer-bottom">
© 2026 Perpustakaan Digital SMKN 3 Banjar. Semua Hak Dilindungi.
</div>

</footer>