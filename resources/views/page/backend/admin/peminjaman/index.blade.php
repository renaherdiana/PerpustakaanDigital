@extends('layouts.backend.admin.app')

@section('content')

<style>
/* --- TITLE --- */
.page-title{
    font-weight:700;
    font-size:20px;
    margin-bottom:22px;
    color:#1e293b;
}

/* --- CARD --- */
.card-custom{
    border:none;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
    padding:22px;
    background:white;
}

/* --- FILTER --- */
.filter-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}
.filter-left{
    display:flex;
    gap:14px;
}
.filter-left input,
.filter-left select{
    min-width:200px;
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #e2e8f0;
    font-size:14px;
}

/* --- TABLE --- */
.table{
    font-size:14px;
}
.table thead{
    background:#f8fafc;
}
.table th{
    font-weight:600;
    color:#475569;
}
.table td{
    vertical-align:middle;
}
.table tbody tr:hover{
    background:#f8fafc;
}

/* --- BADGE --- */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}
.badge-wait{ background:#fef3c7; color:#92400e; }
.badge-borrow{ background:#dbeafe; color:#1e40af; }
.badge-verify{ background:#ede9fe; color:#6d28d9; }
.badge-done{ background:#d1fae5; color:#065f46; }
.badge-danger{ background:#fee2e2; color:#b91c1c; }

/* --- BUTTONS --- */
.btn-action{
    border:none;
    border-radius:8px;
    font-size:13px;
    padding:5px 10px;
}
.icon-btn{
    width:36px;
    height:36px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:17px;
    border:none;
    cursor:pointer;
    text-decoration:none;
    transition:0.2s;
}
.icon-show{ background:#ecfdf5; color:#059669; }
.btn-approve{ background:#dcfce7; color:#166534; }
.btn-reject{ background:#fee2e2; color:#b91c1c; }

/* --- PAGINATION MIRIP DATA BUKU --- */
.pagination{
    display:flex;
    list-style:none;
    gap:4px;
    justify-content:end;
}
.pagination li{
    display:inline-block;
}
.pagination li .page-link{
    padding:6px 12px;
    border-radius:6px;
    border:1px solid #d1d5db;
    color:#1f2937;
    text-decoration:none;
    transition:all 0.2s;
}
.pagination li .page-link:hover{
    background-color:#e2e8f0;
}
.pagination li.active .page-link{
    background-color:#3b82f6;
    color:white;
    border-color:#3b82f6;
}
.pagination li.disabled .page-link{
    pointer-events:none;
    opacity:0.5;
}
</style>

<div class="card card-custom">
    <div class="card-body">

        <h5 class="page-title">Data Peminjaman</h5>

        <div class="filter-area">
            <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="filter-left">
                <input type="text" name="search" placeholder="Cari anggota / buku" value="{{ request('search') }}">
                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="dipinjam" {{ request('status')=='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="menunggu_verifikasi" {{ request('status')=='menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="terlambat" {{ request('status')=='terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit" style="padding:8px 14px; background:#4f7cff; color:white; border:none; border-radius:10px; cursor:pointer;">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle" id="peminjamanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Jumlah Pinjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $no => $p)
                    <tr>
                        <td>{{ $peminjamans->firstItem() + $no }}</td>
                        <td>{{ $p->nama_anggota }}</td>
                        <td>{{ optional($p->buku)->judul }}</td>
                        <td>{{ $p->jumlah }}</td>
                        <td>{{ $p->tgl_pinjam }}</td>
                        <td>{{ $p->tgl_kembali }}</td>
                        <td>
                            @if($p->status == 'menunggu')
                                <span class="badge badge-wait" data-status="menunggu">Menunggu</span>
                            @elseif($p->status == 'dipinjam')
                                <span class="badge badge-borrow" data-status="dipinjam">Dipinjam</span>
                            @elseif($p->status == 'menunggu_verifikasi')
                                <span class="badge badge-verify" data-status="menunggu_verifikasi">Menunggu Verifikasi</span>
                            @elseif($p->status == 'terlambat')
                                <span class="badge badge-danger" data-status="terlambat">Terlambat</span>
                            @elseif($p->status == 'selesai')
                                <span class="badge badge-done" data-status="selesai">Selesai</span>
                            @elseif($p->status == 'ditolak')
                                <span class="badge badge-danger" data-status="ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status == 'menunggu')
                                <form action="{{ route('admin.peminjaman.update',$p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="dipinjam">
                                    <button class="btn-action btn-approve">✔</button>
                                </form>
                                <form action="{{ route('admin.peminjaman.update',$p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button class="btn-action btn-reject">✖</button>
                                </form>
                            @else
                                <a href="{{ route('admin.peminjaman.show',$p->id) }}" class="icon-btn icon-show">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- CUSTOM PAGINATION -->
        @php
            $totalPages = $peminjamans->lastPage();
            $currentPage = $peminjamans->currentPage();
        @endphp
        @if($totalPages > 1)
        <ul class="pagination">
            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $peminjamans->url($currentPage - 1) }}">Previous</a>
            </li>

            @for($i = 1; $i <= $totalPages; $i++)
                @if($i == 1 || $i == $totalPages || ($i >= $currentPage - 2 && $i <= $currentPage + 2))
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $peminjamans->url($i) }}">{{ $i }}</a>
                    </li>
                @elseif($i == 2 && $currentPage > 4)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @elseif($i == $totalPages - 1 && $currentPage < $totalPages - 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endfor

            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $peminjamans->url($currentPage + 1) }}">Next</a>
            </li>
        </ul>
        @endif

    </div>
</div>



@endsection