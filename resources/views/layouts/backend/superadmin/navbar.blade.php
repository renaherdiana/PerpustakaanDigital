<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">
    <img src="{{ asset('assetsfrontend/img/perpustakaan.png') }}" width="35" class="me-2">

    <h5 class="mb-0 fw-bold">
        E-Library SMKN 3 Banjar
    </h5>
</div>


<!-- PROFILE RIGHT -->
<div class="dropdown">

<div class="d-flex align-items-center gap-2 profile-nav"
     role="button"
     data-bs-toggle="dropdown">

<img src="https://i.pravatar.cc/40" class="profile-img">

<span class="fw-semibold">Rena</span>

</div>

<ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

<li>
<a class="dropdown-item py-2" href="/profile">
👤 Edit Profil
</a>
</li>

</ul>

</div>

</nav>


<style>

.profile-nav{
cursor:pointer;
padding:6px 10px;
border-radius:8px;
transition:0.2s;
}

.profile-nav:hover{
background:#f6f6f6;
}

.profile-img{
width:35px;
height:35px;
border-radius:50%;
object-fit:cover;
}

</style>