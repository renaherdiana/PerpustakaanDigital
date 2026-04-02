<div class="sidebar">

<style>

/* SIDEBAR */
.sidebar{
    width:270px;
    min-height:100vh;
    background:#ffffff;
    box-shadow:0 0 10px rgba(0,0,0,0.04);
    padding:25px;
}

/* PROFILE */
.sidebar-profile{
    text-align:center;
    margin-bottom:25px;
}

.sidebar-profile img{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:10px;
}

.sidebar-profile h6{
    font-weight:600;
    margin:0;
}

.sidebar-profile small{
    color:#8a8a8a;
}

/* MENU */
.sidebar-menu{
    list-style:none;
    padding:0;
}

.sidebar-menu li{
    margin-bottom:10px;
}

.sidebar-menu a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 12px;
    border-radius:10px;
    text-decoration:none;
    color:#555;
    font-weight:500;
    transition:0.2s;
}

/* HOVER */
.sidebar-menu a:hover{
    background:#f3f1ff;
    color:#7c6cf3;
}

/* ACTIVE */
.sidebar-menu a.active{
    background:#ece9ff;
    color:#6a5af9;
    font-weight:600;
}

/* LOGOUT */
.sidebar-menu .logout{
    color:#e57373;
}

</style>


<!-- PROFILE -->
<div class="sidebar-profile">

<img src="https://i.pravatar.cc/150">

<h6>Admin</h6>
<small>Petugas Perpustakaan</small>

</div>

<hr>

<!-- MENU -->
<ul class="sidebar-menu">

<li>
<a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
<span>🏠</span>
<span>Dashboard</span>
</a>
</li>

<li>
<a href="/admin/dataanggota" class="{{ request()->is('admin/dataanggota') ? 'active' : '' }}">
<span>👥</span>
<span>Data Anggota</span>
</a>
</li>

<li>
<a href="/admin/databuku" class="{{ request()->is('admin/databuku') ? 'active' : '' }}">
<span>📚</span>
<span>Data Buku</span>
</a>
</li>

<li>
<a href="/admin/peminjaman" class="{{ request()->is('admin/peminjaman') ? 'active' : '' }}">
<span>📖</span>
<span>Data Peminjaman</span>
</a>
</li>

<li>
<a href="/admin/pengembalian" class="{{ request()->is('admin/pengembalian') ? 'active' : '' }}">
<span>🔄</span>
<span>Data Pengembalian</span>
</a>
</li>

<li>
<a href="/admin/denda" class="{{ request()->is('admin/denda') ? 'active' : '' }}">
<span>💰</span>
<span>Denda</span>
</a>
</li>

<li>
<a href="/admin/laporan" class="{{ request()->is('admin/laporan') ? 'active' : '' }}">
<span>📊</span>
<span>Laporan</span>
</a>
</li>

<hr style="margin:12px 0; opacity:0.2;">

<li>
<a href="/logout" class="logout">
<span>🚪</span>
<span>Logout</span>
</a>
</li>

</ul>

</div>