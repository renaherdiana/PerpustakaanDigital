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

<h6>Rena Herdiana</h6>
<small>Super Admin</small>

</div>

<hr>

<!-- MENU -->
<ul class="sidebar-menu">

<li>
<a href="/superadmin/dashboard" class="{{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
<span>🏠</span>
<span>Dashboard</span>
</a>
</li>

<li>
<a href="/superadmin/datauser" class="{{ request()->is('superadmin/datauser') ? 'active' : '' }}">
<span>👥</span>
<span>Data User</span>
</a>
</li>

<li>
<a href="/superadmin/laporanperpustakaan" class="{{ request()->is('superadmin/laporanperpustakaan') ? 'active' : '' }}">
<span>📊</span>
<span>Laporan Perpustakaan</span>
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