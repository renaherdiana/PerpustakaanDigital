@extends('layouts.backend.admin.app')

@section('content')

<style>
/* --- HEADER & CARD --- */
.page-title{font-weight:700;font-size:20px;margin-bottom:25px;color:#3b3b3b;}
.report-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:20px;}
.report-card{display:flex;align-items:center;gap:15px;padding:22px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);cursor:pointer;transition:0.3s;}
.report-card:hover{transform:translateY(-3px);}
.report-card.active{border:2px solid #6366f1;background:#eef2ff;}
.card-buku{background:#eef2ff;}
.card-pinjam{background:#ecfdf5;}
.card-kembali{background:#fff7ed;}
.card-denda{background:#fef2f2;}
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
        denda:`<tr><th>No</th><th>Nama Peminjam</th><th>Jumlah Buku</th><th>Hari Terlambat</th><th>Total Denda</th><th>Status</th></tr>`
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
        const bulan = document.getElementById("filterBulan").value;
        const tahun = document.getElementById("filterTahun").value;
        const bulanLabel = bulan ? document.getElementById("filterBulan").options[document.getElementById("filterBulan").selectedIndex].text : 'Semua Bulan';
        const tahunLabel = tahun ? tahun : 'Semua Tahun';

        const judulLaporan = {
            buku: 'Laporan Data Buku',
            peminjaman: 'Laporan Peminjaman Buku',
            pengembalian: 'Laporan Pengembalian Buku',
            denda: 'Laporan Denda'
        }[activeKategori];

        const tableHTML = document.getElementById("laporanTable").outerHTML;
        const tanggalCetak = new Date().toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});

        const WinPrint = window.open('', '', 'width=1000,height=700');
        WinPrint.document.write(`
        <html>
        <head>
            <title>${judulLaporan}</title>
            <style>
                * { margin:0; padding:0; box-sizing:border-box; }
                body { font-family: Arial, sans-serif; font-size: 13px; color: #1a1a1a; padding: 30px 40px; }

                /* KOP */
                .kop { display:flex; align-items:center; gap:18px; border-bottom: 3px solid #4a4e69; padding-bottom: 14px; margin-bottom: 6px; }
                .kop-text h2 { font-size: 16px; font-weight: 700; color: #4a4e69; margin-bottom: 2px; }
                .kop-text p { font-size: 12px; color: #555; }
                .kop-icon { font-size: 42px; }

                /* JUDUL */
                .judul-laporan { text-align: center; margin: 18px 0 4px; }
                .judul-laporan h3 { font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1a1a1a; }
                .judul-laporan .periode { font-size: 12px; color: #666; margin-top: 4px; }
                .garis { border: none; border-top: 1px solid #ccc; margin: 12px 0; }

                /* INFO */
                .info-row { display:flex; justify-content:space-between; font-size:12px; color:#555; margin-bottom: 14px; }

                /* TABLE */
                table { width: 100%; border-collapse: collapse; margin-top: 6px; }
                thead tr { background: #4a4e69; color: white; }
                th { padding: 9px 10px; text-align: left; font-size: 12px; font-weight: 600; }
                td { padding: 8px 10px; font-size: 12px; border-bottom: 1px solid #e8e8e8; }
                tbody tr:nth-child(even) { background: #f7f8fc; }
                tbody tr:last-child td { border-bottom: 2px solid #4a4e69; }

                /* BADGE */
                .badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
                .badge-available,.badge-paid { background:#d1fae5; color:#065f46; }
                .badge-empty,.badge-danger { background:#fee2e2; color:#991b1b; }
                .badge-wait { background:#fef3c7; color:#92400e; }
                .badge-borrow { background:#bfdbfe; color:#1e40af; }
                .badge-default { background:#e5e7eb; color:#374151; }

                /* FOOTER */
                .footer { margin-top: 30px; display:flex; justify-content:flex-end; font-size:12px; color:#555; }
                .ttd { text-align:center; }
                .ttd .nama { margin-top: 50px; font-weight: 700; border-top: 1px solid #333; padding-top: 4px; }

                @media print { body { padding: 20px; } }
            </style>
        </head>
        <body>
            <div class="kop">
                <div class="kop-icon"><img src="${window.location.origin}/assetsfrontend/img/perpustakaan.png" style="width:55px;height:55px;object-fit:contain;"></div>
                <div class="kop-text">
                    <h2>E-Library SMKN 3 Banjar</h2>
                    <p>Sistem Informasi Perpustakaan Digital</p>
                    <p>Jl. Julaeni RT/RW 05/02 Langensari, Kec. Langensari, Kota Banjar, Jawa Barat</p>
                </div>
            </div>

            <div class="judul-laporan">
                <h3>${judulLaporan}</h3>
                <div class="periode">Periode: ${bulanLabel} ${tahunLabel}</div>
            </div>

            <hr class="garis">

            <div class="info-row">
                <span>Dicetak oleh: Petugas</span>
                <span>Tanggal Cetak: ${tanggalCetak}</span>
            </div>

            ${tableHTML}

            <div class="footer">
                <div class="ttd">
                    <div>Banjar, ${tanggalCetak}</div>
                    <div>Petugas Perpustakaan</div>
                    <div class="nama">( ________________ )</div>
                </div>
            </div>
        </body>
        </html>
        `);
        WinPrint.document.close();
        WinPrint.focus();
        setTimeout(() => { WinPrint.print(); WinPrint.close(); }, 500);
    });
});
</script>

@endsection