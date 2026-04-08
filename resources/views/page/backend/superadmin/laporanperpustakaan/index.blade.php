@extends('layouts.backend.superadmin.app')

@section('content')

<style>
/* --- HEADER & CARD --- */
.page-title{font-weight:700;font-size:20px;margin-bottom:25px;color:#3b3b3b;}
.report-cards{display:grid;grid-template-columns:repeat(5,1fr);gap:20px;margin-bottom:20px;}
.report-card{display:flex;align-items:center;gap:15px;padding:22px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);cursor:pointer;transition:0.3s;}
.report-card:hover{transform:translateY(-3px);}
.report-card.active{border:2px solid #6366f1;background:#eef2ff;}
.card-buku{background:#eef2ff;}
.card-pinjam{background:#ecfdf5;}
.card-kembali{background:#fff7ed;}
.card-denda{background:#fef2f2;}
.card-anggota{background:#fde68a;}
.report-icon{font-size:28px;}
.report-info h3{margin:0;font-size:22px;font-weight:700;}
.report-info p{margin:0;font-size:13px;color:#666;}
.card-custom{border:none;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);padding:20px;}
.table thead{background:#f8f8fb;}
.badge{padding:6px 12px;border-radius:20px;font-size:12px;}
.badge-available{background:#d1fae5;color:#065f46;}
.badge-empty{background:#fee2e2;color:#991b1b;}
.badge-wait{background:#fef3c7;color:#92400e;}
.badge-paid{background:#d1fae5;color:#065f46;}
.badge-borrow{background:#bfdbfe;color:#1e40af;}
.badge-default{background:#e5e7eb;color:#374151;}

/* FILTER AREA */
.filter-area{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    align-items:center;
    margin-bottom:15px;
}
.filter-area select, .filter-area button{
    padding:6px 12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
.filter-area select{
    min-width:160px;
}
.filter-area button{
    background:#6366f1;
    color:white;
    border:none;
    cursor:pointer;
    min-width:100px;
}
</style>

<h5 class="page-title">Data Laporan</h5>

<div class="report-cards">
    <div class="report-card card-buku filter-card active" data-kategori="buku">
        <div class="report-icon">📚</div>
        <div class="report-info">
            <h3>{{ $countBuku }}</h3>
            <p>Laporan Buku</p>
        </div>
    </div>
    <div class="report-card card-pinjam filter-card" data-kategori="peminjaman">
        <div class="report-icon">📖</div>
        <div class="report-info">
            <h3>{{ $countPinjam }}</h3>
            <p>Laporan Peminjaman</p>
        </div>
    </div>
    <div class="report-card card-kembali filter-card" data-kategori="pengembalian">
        <div class="report-icon">🔁</div>
        <div class="report-info">
            <h3>{{ $countKembali }}</h3>
            <p>Laporan Pengembalian</p>
        </div>
    </div>
    <div class="report-card card-denda filter-card" data-kategori="denda">
        <div class="report-icon">💰</div>
        <div class="report-info">
            <h3>{{ $countDenda }}</h3>
            <p>Laporan Denda</p>
        </div>
    </div>
    <div class="report-card card-anggota filter-card" data-kategori="anggota">
        <div class="report-icon">👤</div>
        <div class="report-info">
            <h3>{{ $countAnggota }}</h3>
            <p>Laporan Anggota</p>
        </div>
    </div>
</div>

<!-- FILTER BULAN & TAHUN + CETAK -->
<div class="filter-area">
    <select id="filterBulan" class="form-select">
        <option value="">Semua Bulan</option>
        @for($m=1;$m<=12;$m++)
        <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
        @endfor
    </select>

    <select id="filterTahun" class="form-select">
        <option value="">Semua Tahun</option>
        @for($y = date('Y')-5; $y <= date('Y'); $y++)
        <option value="{{ $y }}">{{ $y }}</option>
        @endfor
    </select>

    <button id="btnFilter">Filter</button>
    <button id="btnCetak">Cetak</button>
</div>

<div class="card card-custom">
<div class="card-body">
<div class="table-responsive">

<table class="table align-middle" id="laporanTable">
<thead id="laporanHeader"></thead>
<tbody>

{{-- BUKU --}}
@foreach($buku as $item)
<tr data-kategori="buku" data-bulan="{{ $item->created_at->format('m') }}" data-tahun="{{ $item->created_at->format('Y') }}">
<td>{{ $loop->iteration }}</td>
<td>{{ $item->judul }}</td>
<td>{{ $item->stok }}</td>
<td>
@if($item->stok>0)
<span class="badge badge-available">Tersedia</span>
@else
<span class="badge badge-empty">Habis</span>
@endif
</td>
<td>{{ $item->created_at->format('d M Y') }}</td>
</tr>
@endforeach

{{-- PEMINJAMAN --}}
@foreach($peminjaman as $item)
<tr data-kategori="peminjaman" data-bulan="{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('m') }}" data-tahun="{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('Y') }}" style="display:none;">
<td>{{ $loop->iteration }}</td>
<td>{{ $item->nama_anggota }}</td>
<td>{{ $item->buku->judul ?? '-' }}</td>
<td>{{ $item->jumlah ?? 1 }}</td>
<td>{{ $item->tgl_pinjam }}</td>
<td>
@php $status = strtolower($item->status ?? 'menunggu'); @endphp
<span class="badge @if($status=='selesai') badge-paid @elseif($status=='dipinjam') badge-borrow @elseif($status=='menunggu') badge-wait @else badge-default @endif">
{{ ucwords($status) }}
</span>
</td>
</tr>
@endforeach

{{-- PENGEMBALIAN --}}
@foreach($pengembalian as $item)
<tr data-kategori="pengembalian" data-bulan="{{ \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('m') }}" data-tahun="{{ \Carbon\Carbon::parse($item->tgl_dikembalikan)->format('Y') }}" style="display:none;">
<td>{{ $loop->iteration }}</td>
<td>{{ $item->peminjaman->nama_anggota ?? '-' }}</td>
<td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
<td>{{ $item->peminjaman->jumlah ?? 1 }}</td>
<td>{{ $item->tgl_dikembalikan }}</td>
<td>
@php $status = strtolower($item->peminjaman->status ?? 'menunggu'); @endphp
<span class="badge @if($status=='selesai') badge-paid @elseif($status=='dipinjam') badge-borrow @elseif($status=='menunggu') badge-wait @else badge-default @endif">
{{ ucwords($status) }}
</span>
</td>
</tr>
@endforeach

{{-- DENDA --}}
@foreach($denda as $item)
<tr data-kategori="denda" data-bulan="{{ \Carbon\Carbon::parse($item->created_at)->format('m') }}" data-tahun="{{ \Carbon\Carbon::parse($item->created_at)->format('Y') }}" style="display:none;">
<td>{{ $loop->iteration }}</td>
<td>{{ $item->peminjaman->nama_anggota ?? '-' }}</td>
<td>{{ $item->peminjaman->jumlah ?? 1 }}</td>
<td>{{ $item->hari_terlambat ?? 0 }} Hari</td>
@php
$totalDenda = ($item->hari_terlambat ?? 0) * 1000 * ($item->peminjaman->jumlah ?? 1);
$status = strtolower($item->status ?? 'belum');
@endphp
<td>Rp {{ number_format($totalDenda,0,',','.') }}</td>
<td>
@if($status=='selesai')
<span class="badge badge-paid">Lunas</span>
@else
<span class="badge badge-wait">Belum Dibayar</span>
@endif
</td>
</tr>
@endforeach

{{-- ANGGOTA --}}
@foreach($anggota as $item)
<tr data-kategori="anggota" data-bulan="{{ $item->created_at->format('m') }}" data-tahun="{{ $item->created_at->format('Y') }}" style="display:none;">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->nis }}</td>
    <td>{{ $item->kelas }}</td>
    @php $status = strtolower($item->status ?? 'aktif'); @endphp
    <td>
        <span class="badge @if($status=='aktif') badge-available @else badge-empty @endif">{{ ucwords($status) }}</span>
    </td>
</tr>
@endforeach

</tbody>
</table>

</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const cards = document.querySelectorAll(".filter-card");
    const rows = document.querySelectorAll("#laporanTable tbody tr");
    const header = document.getElementById("laporanHeader");

    const headers = {
        buku:`<tr><th>No</th><th>Judul Buku</th><th>Stok</th><th>Status</th><th>Tanggal Masuk</th></tr>`,
        peminjaman:`<tr><th>No</th><th>Nama Peminjam</th><th>Buku</th><th>Jumlah Pinjam</th><th>Tanggal Peminjaman</th><th>Status</th></tr>`,
        pengembalian:`<tr><th>No</th><th>Nama Peminjam</th><th>Buku</th><th>Jumlah Pinjam</th><th>Tanggal Dikembalikan</th><th>Status</th></tr>`,
        denda:`<tr><th>No</th><th>Nama Peminjam</th><th>Jumlah Buku</th><th>Hari Terlambat</th><th>Total Denda</th><th>Status</th></tr>`,
        anggota:`<tr><th>No</th><th>Nama</th><th>NIS</th><th>Kelas</th><th>Status</th></tr>`
    };

    let activeKategori = "buku";

    function filterKategori(kategori){
        activeKategori = kategori;
        rows.forEach(row => row.style.display = (row.dataset.kategori === kategori ? "" : "none"));
        header.innerHTML = headers[kategori];
        document.getElementById("filterBulan").value = "";
        document.getElementById("filterTahun").value = "";
    }

    cards.forEach(card => {
        card.addEventListener("click", function(){
            cards.forEach(c=>c.classList.remove("active"));
            this.classList.add("active");
            filterKategori(this.dataset.kategori);
        });
    });

    filterKategori("buku");

    document.getElementById("btnFilter").addEventListener("click", function(){
        const bulan = document.getElementById("filterBulan").value;
        const tahun = document.getElementById("filterTahun").value;
        rows.forEach(row=>{
            if(row.dataset.kategori === activeKategori){
                const rowBulan = row.dataset.bulan;
                const rowTahun = row.dataset.tahun;
                if((bulan==="" || rowBulan===bulan) && (tahun==="" || rowTahun===tahun)){
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });

    document.getElementById("btnCetak").addEventListener("click", function(){
        let printContent = document.getElementById("laporanTable").outerHTML;
        let WinPrint = window.open('', '', 'width=900,height=650');
        WinPrint.document.write('<html><head><title>Laporan</title><style>table{width:100%;border-collapse:collapse;}th,td{border:1px solid #000;padding:6px;text-align:left;}thead{background:#f8f8fb;}</style></head><body>');
        WinPrint.document.write(printContent);
        WinPrint.document.write('</body></html>');
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    });
});
</script>

@endsection