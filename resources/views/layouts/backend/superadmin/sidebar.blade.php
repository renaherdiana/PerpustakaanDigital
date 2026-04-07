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

    /* LOGOUT BUTTON */
    .sidebar-menu button.logout{
        width:100%;
        display:flex;
        align-items:center;
        gap:10px;
        padding:10px 12px;
        border-radius:10px;
        border:none;
        background:none;
        color:#e57373;
        font-weight:500;
        cursor:pointer;
        transition:0.2s;
    }

    /* LOGOUT HOVER */
    .sidebar-menu button.logout:hover{
        background:#f5f5f5;
    }

    /* LOGOUT CLICK */
    .sidebar-menu button.logout:active{
        background:#e8e8e8;
    }
    </style>


    <!-- PROFILE -->
    <div class="sidebar-profile">
        <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : 'https://i.pravatar.cc/150' }}">
        <h6>{{ Auth::user()->name }}</h6>
        <small>{{ ucfirst(Auth::user()->role) }}</small>
    </div>

    <hr>

    <!-- MENU -->
    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('superadmin.dashboard') }}" 
               class="{{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
                <span>🏠</span>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('superadmin.datauser.index') }}" 
               class="{{ request()->is('superadmin/datauser*') ? 'active' : '' }}">
                <span>👥</span>
                <span>Data User</span>
            </a>
        </li>

        <li>
            <a href="{{ route('superadmin.laporan.perpustakaan') }}" 
               class="{{ request()->is('superadmin/laporanperpustakaan') ? 'active' : '' }}">
                <span>📊</span>
                <span>Laporan Perpustakaan</span>
            </a>
        </li>

        <hr style="margin:12px 0; opacity:0.2;">

        <!-- LOGOUT -->
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">
                    <span>🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </li>

    </ul>

</div>