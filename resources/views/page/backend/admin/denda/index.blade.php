@extends('layouts.backend.admin.app')

@section('content')

<style>
.page-title { font-weight:700; font-size:20px; color:#1e293b; margin-bottom:22px; }

.card-custom {
    border: none;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    padding: 24px;
    background: white;
}

/* SUMMARY CARDS */
.summary-row {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}

.summary-card {
    flex: 1;
    border-radius: 12px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.summary-card .s-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.summary-card .s-label { font-size: 12px; color: #888; margin-bottom: 2px; }
.summary-card .s-value { font-size: 20px; font-weight: 700; color: #1e293b; }

.sc-yellow { background: #fffbeb; }
.sc-yellow .s-icon { background: #fef3c7; }

.sc-green { background: #f0fdf4; }
.sc-green .s-icon { background: #dcfce7; }

.sc-red { background: #fff5f5; }
.sc-red .s-icon { background: #fee2e2; }

/* FILTER */
.filter-area {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.filter-area input {
    padding: 9px 14px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    font-size: 14px;
    min-width: 260px;
    outline: none;
    transition: 0.2s;
}

.filter-area input:focus { border-color: #2bb3c0; }

/* TABLE */
.table { font-size: 13.5px; }
.table thead { background: #f8fafc; }
.table th { font-weight: 600; color: #475569; padding: 12px 14px; }
.table td { vertical-align: middle; padding: 12px 14px; color: #334155; }
.table tbody tr:hover { background: #f8fafc; }

/* BADGE */
.badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-wait { background: #fef3c7; color: #92400e; }
.badge-paid { background: #d1fae5; color: #065f46; }

/* DENDA VALUE */
.denda-value { font-weight: 700; color: #dc2626; }

/* ACTION */
.btn-verify {
    background: #dcfce7;
    color: #166534;
    border: none;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}
.btn-verify:hover { background: #bbf7d0; }

.icon-btn {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: 0.2s;
}
.icon-show { background: #ecfdf5; color: #059669; }
.icon-show:hover { background: #d1fae5; }

/* PAGINATION */
.pagination { display:flex; list-style:none; gap:4px; justify-content:end; margin-top:16px; padding:0; }
.pagination li .page-link { padding:6px 12px; border-radius:6px; border:1px solid #e2e8f0; color:#1f2937; text-decoration:none; font-size:13px; transition:0.2s; }
.pagination li .page-link:hover { background:#e2e8f0; }
.pagination li.active .page-link { background:#2bb3c0; color:white; border-color:#2bb3c0; }
.pagination li.disabled .page-link { opacity:0.4; pointer-events:none; }
</style>

<div class="card card-custom">
    <div class="card-body">

        <h5 class="page-title">Data Denda</h5>

        @php
            $totalMenunggu = 0;
            $totalLunas    = 0;
            $totalNominal  = 0;
            foreach($dendas as $item) {
                $totalNominal += $item->denda ?? 0;
                if($item->status == 'selesai') $totalLunas++;
                else $totalMenunggu++;
            }
        @endphp

        <!-- SUMMARY -->
        <div class="summary-row">
            <div class="summary-card sc-yellow">
                <div class="s-icon">⏳</div>
                <div>
                    <div class="s-label">Belum Lunas</div>
                    <div class="s-value">{{ $totalMenunggu }}</div>
                </div>
            </div>
            <div class="summary-card sc-green">
                <div class="s-icon">✅</div>
                <div>
                    <div class="s-label">Sudah Lunas</div>
                    <div class="s-value">{{ $totalLunas }}</div>
                </div>
            </div>
            <div class="summary-card sc-red">
                <div class="s-icon">💰</div>
                <div>
                    <div class="s-label">Total Nominal</div>
                    <div class="s-value">Rp {{ number_format($totalNominal,0,',','.') }}</div>
                </div>
            </div>
        </div>

        <!-- FILTER -->
        <form method="GET" action="{{ route('admin.denda.index') }}" class="filter-area">
            <div style="display:flex; gap:10px;">
                <input type="text" name="search" placeholder=" Cari anggota atau judul buku..." value="{{ request('search') }}">
                <select name="status" onchange="this.form.submit()" style="padding:9px 14px; border-radius:10px; border:1.5px solid #e2e8f0; font-size:14px; outline:none;">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Lunas</option>
                </select>
                <button type="submit" style="padding:9px 16px; background:#2bb3c0; color:white; border:none; border-radius:10px; font-size:14px; cursor:pointer;">Cari</button>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table" id="dendaTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tgl Kembali</th>
                        <th>Hari Terlambat</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dendas as $no => $item)
                        <tr>
                            <td>{{ $dendas->firstItem() + $no }}</td>
                            <td><strong>{{ $item->peminjaman->nama_anggota ?? '-' }}</strong></td>
                            <td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->peminjaman->tgl_kembali)->format('d M Y') }}</td>
                            <td>
                                @if($item->jenis == 'kerusakan')
                                    <span style="color:#f97316;font-weight:600;">Kerusakan Buku</span>
                                @elseif($item->jenis == 'hilang')
                                    <span style="color:#dc2626;font-weight:600;">Buku Hilang</span>
                                @else
                                    {{ $item->hari_terlambat }} hari
                                @endif
                            </td>
                            <td class="denda-value">Rp {{ number_format($item->denda,0,',','.') }}</td>
                            <td>
                                @if($item->status == 'selesai')
                                    <span class="badge badge-paid">Lunas</span>
                                @else
                                    <span class="badge badge-wait">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status != 'selesai')
                                    <form action="{{ route('admin.denda.bayar', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-verify">✔ Lunas</button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.denda.show', $item->id) }}" class="icon-btn icon-show">👁</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada data denda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @php
            $totalPages  = $dendas->lastPage();
            $currentPage = $dendas->currentPage();
        @endphp
        @if($totalPages > 1)
        <ul class="pagination">
            <li class="{{ $currentPage == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $dendas->url($currentPage - 1) }}">‹</a>
            </li>
            @for($i = 1; $i <= $totalPages; $i++)
                @if($i == 1 || $i == $totalPages || ($i >= $currentPage - 2 && $i <= $currentPage + 2))
                    <li class="{{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $dendas->url($i) }}">{{ $i }}</a>
                    </li>
                @elseif($i == 2 && $currentPage > 4)
                    <li class="disabled"><span class="page-link">…</span></li>
                @elseif($i == $totalPages - 1 && $currentPage < $totalPages - 3)
                    <li class="disabled"><span class="page-link">…</span></li>
                @endif
            @endfor
            <li class="{{ $currentPage == $totalPages ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $dendas->url($currentPage + 1) }}">›</a>
            </li>
        </ul>
        @endif

    </div>
</div>



@endsection
