@extends('layouts.frontend.app')

@section('content')

<style>
/* HEADER */
.header-page{
    background:#4a4e69;
    color:white;
    padding:70px 0;
    text-align:center;
    margin-bottom:40px;
}

/* SEARCH */
.search-box{
    display:flex;
    gap:10px;
    margin-bottom:25px;
}

.search-input{
    width:230px;
    padding:8px 12px;
    border:1px solid #cfd3e1;
    border-radius:6px;
}

.search-select{
    padding:8px 12px;
    border:1px solid #cfd3e1;
    border-radius:6px;
}

/* TABLE */
.table-custom{
    border-collapse:separate;
    border-spacing:0 12px;
    width:100%;
}

.table-header{
    background:#4a4e69;
    color:white;
}

.table-header th{
    padding:12px;
    text-align:center;
}

.table-row{
    background:white;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
    transition:0.2s;
}

.table-row:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(0,0,0,0.12);
}

.table-row td{
    padding:14px;
    text-align:center;
}

/* STATUS */
.badge{
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    color:white;
}

.badge-menunggu{ background:#f39c12; }
.badge-dipinjam{ background:#2ecc71; }
.badge-verifikasi{ background:#6c757d; }
.badge-selesai{ background:#17a2b8; }
.badge-ditolak{ background:#e74c3c; }
.badge-terlambat{ background:#e74c3c; }

/* BUTTON */
.btn-kembali{
    background:#3498db;
    color:white;
    border:none;
    padding:7px 16px;
    border-radius:8px;
    cursor:pointer;
    transition:all .2s ease;
}

.btn-kembali:hover{
    background:#2980b9;
    transform:translateY(-1px);
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

.btn-lihat{
    background:#3498db;
    color:white;
    border:none;
    padding:7px 16px;
    border-radius:8px;
    text-decoration:none;
    transition:all .2s ease;
}

.btn-lihat:hover{
    background:#2980b9;
    color:white;
    transform:translateY(-1px);
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

.btn-menunggu{
    background:#bdc3c7;
    color:white;
    border:none;
    padding:7px 16px;
    border-radius:8px;
}

/* POPUP */
.popup-bg{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    backdrop-filter:blur(5px);
    display:none; /* penting! jangan display:flex di sini */
    align-items:center;
    justify-content:center;
    z-index:999;
    animation:fadeIn .3s ease;
}

@keyframes fadeIn{
    from{opacity:0;}
    to{opacity:1;}
}

.popup-box{
    background:white;
    color:#333;
    width:380px;
    padding:30px;
    border-radius:16px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
    animation:popupScale .3s ease;
}

@keyframes popupScale{
    from{ transform:scale(.9); opacity:0; }
    to{ transform:scale(1); opacity:1; }
}

.popup-box h4{
    margin-bottom:20px;
    color:#2c3e50;
}

.popup-input{
    background:#f4f6f9;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
    text-align:left;
    font-size:14px;
}

#statusInfo{
    text-align:left;
    margin-top:10px;
    font-weight:600;
}

#dendaInfo{
    text-align:left;
    margin-top:8px;
    font-size:14px;
}

.popup-btn{
    display:flex;
    justify-content:space-between;
    margin-top:20px;
}

.btn-batal{
    background:#b0b6bd;
    border:none;
    padding:8px 20px;
    border-radius:8px;
    color:white;
    cursor:pointer;
    transition:0.2s;
}

.btn-batal:hover{
    background:#8d939a;
}

.btn-ajukan{
    background:#4aa3ff;
    border:none;
    padding:8px 20px;
    border-radius:8px;
    color:white;
    cursor:pointer;
    transition:0.2s;
}

.btn-ajukan:hover{
    background:#2f8df5;
    transform:scale(1.05);
}
</style>

<div class="header-page">
    <h2>Peminjaman Saya</h2>
</div>

<div class="container">

    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Cari Buku">
        <select id="statusFilter" class="search-select">
            <option value="">Semua Status</option>
            <option value="menunggu">Menunggu</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="terlambat">Terlambat</option>
            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
            <option value="selesai">Selesai</option>
            <option value="ditolak">Ditolak</option>
        </select>
    </div>

    <table class="table-custom">
        <thead class="table-header">
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($peminjamans as $p)
                @php
                    $today = \Carbon\Carbon::today();
                    $kembali = \Carbon\Carbon::parse($p->tgl_kembali);
                    $statusRow = $p->status;
                    if($p->status == 'dipinjam' && $today->gt($kembali)){
                        $statusRow = 'terlambat';
                    }
                @endphp
                <tr class="table-row"
                    data-judul="{{ strtolower(optional($p->buku)->judul ?? '') }}"
                    data-status="{{ strtolower($statusRow) }}">
                    <td>{{ $peminjamans->firstItem() + $loop->index }}</td>
                    <td>{{ optional($p->buku)->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('Y-m-d') }}</td>
                    <td>
                        @if($statusRow=='menunggu') 
                            <span class="badge badge-menunggu">Menunggu</span>
                        @elseif($statusRow=='dipinjam') 
                            <span class="badge badge-dipinjam">Dipinjam</span>
                        @elseif($statusRow=='terlambat') 
                            <span class="badge badge-terlambat">Terlambat</span>
                        @elseif($statusRow=='menunggu_verifikasi') 
                            <span class="badge badge-verifikasi">Menunggu Verifikasi</span>
                        @elseif($statusRow=='selesai') 
                            <span class="badge badge-selesai">Selesai</span>
                        @elseif($statusRow=='ditolak') 
                            <span class="badge badge-ditolak">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($statusRow=='menunggu')
                            <button class="btn-menunggu">Menunggu Persetujuan</button>
                        @elseif($statusRow=='dipinjam' || $statusRow=='terlambat')
                            <button class="btn-kembali"
                                onclick="openPopup('{{ $p->id }}','{{ optional($p->buku)->judul }}','{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('Y-m-d') }}','{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('Y-m-d') }}')">
                                Ajukan Pengembalian
                            </button>
                        @elseif($statusRow=='menunggu_verifikasi')
                            <button class="btn-menunggu">Menunggu Verifikasi</button>
                        @elseif($statusRow=='selesai')
                            <a href="{{ route('peminjamansaya.detail',$p->id) }}" class="btn-lihat">Lihat</a>
                        @elseif($statusRow=='ditolak')
                            <a href="{{ route('peminjamansaya.show',$p->id) }}" class="btn-lihat">Detail</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:20px;">
        {{ $peminjamans->links('vendor.pagination.bootstrap-5') }}
    </div>

</div>

{{-- POPUP PENGEMBALIAN --}}
<div class="popup-bg" id="popupForm">
    <div class="popup-box">
        <h4>Ajukan Pengembalian</h4>
        <div id="judul" class="popup-input"></div>
        <div id="tglPinjam" class="popup-input"></div>
        <div id="tglKembali" class="popup-input"></div>
        <div id="statusInfo"></div>
        <div id="dendaInfo"></div>

        <form action="{{ route('ajukan.pengembalian') }}" method="POST">
            @csrf
            <input type="hidden" name="peminjaman_id" id="peminjaman_id">
            <div class="popup-btn">
                <button type="button" class="btn-batal" onclick="closePopup()">Batal</button>
                <button type="submit" class="btn-ajukan">Ajukan</button>
            </div>
        </form>
    </div>
</div>

{{-- POPUP SUCCESS --}}
@if(session('success'))
<div class="popup-bg" id="popupSuccess">
    <div class="popup-box">
        <h4 style="color:#2ecc71">
            <i class="bi bi-check-circle"></i>
            Berhasil
        </h4>
        <p style="margin-top:10px;font-size:14px;">
            Pengembalian berhasil diajukan<br>Menunggu verifikasi admin
        </p>
        <div style="margin-top:20px">
            <button onclick="document.getElementById('popupSuccess').style.display='none'" class="btn-ajukan">OK</button>
        </div>
    </div>
</div>

<script>
    // Popup success langsung tampil
    document.getElementById("popupSuccess").style.display = "flex";
</script>
@endif

<script>
function openPopup(id,judul,tglPinjam,tglKembali){
    document.getElementById("popupForm").style.display="flex";
    document.getElementById("peminjaman_id").value=id;
    document.getElementById("judul").innerHTML="Judul Buku : "+judul;
    document.getElementById("tglPinjam").innerHTML="Tgl Pinjam : "+tglPinjam;
    document.getElementById("tglKembali").innerHTML="Tgl Kembali : "+tglKembali;

    let today = new Date();
    let kembali = new Date(tglKembali);
    let diffTime = today - kembali;
    let diffDays = Math.floor(diffTime / (1000*60*60*24));

    if(diffDays > 0){
        let denda = diffDays * 1000;
        document.getElementById("statusInfo").innerHTML =
            "<b>Status :</b> <span style='color:red'>Terlambat "+diffDays+" hari</span>";
        document.getElementById("dendaInfo").innerHTML =
            "<b>Estimasi Denda :</b> Rp "+denda;
    } else {
        document.getElementById("statusInfo").innerHTML =
            "<b>Status :</b> <span style='color:#2ecc71'>Tepat Waktu</span>";
        document.getElementById("dendaInfo").innerHTML = "";
    }
}

function closePopup(){
    document.getElementById("popupForm").style.display="none";
}

// FILTER SEARCH & STATUS
const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");

searchInput.addEventListener("keyup", filterTable);
statusFilter.addEventListener("change", filterTable);

function filterTable(){
    let search = searchInput.value.toLowerCase();
    let status = statusFilter.value.toLowerCase();
    let rows = document.querySelectorAll("#tableBody tr");

    rows.forEach(function(row){
        let judul = row.getAttribute("data-judul");
        let statusRow = row.getAttribute("data-status");
        let matchSearch = judul.includes(search);
        let matchStatus = status === "" || statusRow === status;
        row.style.display = (matchSearch && matchStatus) ? "" : "none";
    });
}

</script>

@endsection