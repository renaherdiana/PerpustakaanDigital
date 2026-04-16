@extends('layouts.backend.superadmin.app')

@section('content')

<style>
.dash-greeting { margin-bottom: 28px; }
.dash-greeting h4 { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
.dash-greeting p  { color: #94a3b8; font-size: 14px; }

/* STAT CARDS */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    border-radius: 16px;
    padding: 20px 18px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    transition: 0.3s;
}

.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }

.sc-purple { background: #f0eeff; }
.sc-teal   { background: #e8f9fb; }
.sc-orange { background: #fff7ed; }
.sc-green  { background: #ecfdf5; }
.sc-red    { background: #fff1f2; }
.sc-indigo { background: #f1f5f9; }

.stat-icon { font-size: 26px; }
.stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; }
.stat-value { font-size: 28px; font-weight: 700; color: #1e293b; line-height: 1; }

/* CHART + TABLE ROW */
.bottom-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-top: 4px;
}

.chart-card, .denda-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    padding: 24px;
}

.card-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* DENDA TABLE */
.denda-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.denda-table th { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; padding: 0 0 10px; border-bottom: 1px solid #f1f5f9; }
.denda-table td { padding: 10px 0; border-bottom: 1px solid #f8fafc; color: #334155; vertical-align: middle; }
.denda-table tr:last-child td { border-bottom: none; }

.denda-nominal { font-weight: 700; color: #ef4444; }

.rank-badge {
    width: 24px; height: 24px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: white;
}
.rank-1 { background: #f59e0b; }
.rank-2 { background: #94a3b8; }
.rank-3 { background: #b45309; }
.rank-other { background: #e2e8f0; color: #64748b; }

.badge-lunas    { background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-belum    { background: #fee2e2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
</style>

<div class="dash-greeting">
    <h4>Halo, {{ auth()->user()->name ?? 'Superadmin' }} 👋</h4>
    <p>Selamat datang di dashboard E-Library SMKN 3 Banjar</p>
</div>

<!-- STAT CARDS -->
<div class="stat-grid">
    <div class="stat-card sc-purple">
        <div class="stat-icon">👥</div>
        <div class="stat-label">Total User</div>
        <div class="stat-value">{{ $totalUser }}</div>
    </div>
    <div class="stat-card sc-teal">
        <div class="stat-icon">📚</div>
        <div class="stat-label">Total Buku</div>
        <div class="stat-value">{{ $totalBuku }}</div>
    </div>
    <div class="stat-card sc-orange">
        <div class="stat-icon">🎓</div>
        <div class="stat-label">Total Anggota</div>
        <div class="stat-value">{{ $totalAnggota }}</div>
    </div>
    <div class="stat-card sc-green">
        <div class="stat-icon">📖</div>
        <div class="stat-label">Sedang Dipinjam</div>
        <div class="stat-value">{{ $totalPinjam }}</div>
    </div>
    <div class="stat-card sc-indigo">
        <div class="stat-icon">✅</div>
        <div class="stat-label">Selesai</div>
        <div class="stat-value">{{ $totalSelesai }}</div>
    </div>
    <div class="stat-card sc-red">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Denda Aktif</div>
        <div class="stat-value">{{ $totalDenda }}</div>
    </div>
</div>

<!-- GRAFIK + DENDA TERTINGGI -->
<div class="bottom-grid">

    <!-- GRAFIK -->
    <div class="chart-card">
        <div class="card-title">📊 Statistik Peminjaman & Pengembalian {{ date('Y') }}</div>
        <canvas id="grafikChart" height="110"></canvas>
    </div>

    <!-- DENDA TERTINGGI -->
    <div class="denda-card">
        <div class="card-title">🔥 Denda Tertinggi</div>
        <table class="denda-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Anggota</th>
                    <th>Nominal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dendaTertinggi as $i => $d)
                <tr>
                    <td>
                        <span class="rank-badge {{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : 'rank-other')) }}">
                            {{ $i + 1 }}
                        </span>
                    </td>
                    <td>{{ $d->peminjaman->nama_anggota ?? '-' }}</td>
                    <td class="denda-nominal">Rp {{ number_format($d->denda, 0, ',', '.') }}</td>
                    <td>
                        @if($d->status == 'selesai')
                            <span class="badge-lunas">Lunas</span>
                        @else
                            <span class="badge-belum">Belum</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#aaa; padding:20px 0;">Belum ada denda</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const dataPinjam = @json($grafikPeminjaman->pluck('total'));
const dataKembali = @json($grafikPengembalian->pluck('total'));

new Chart(document.getElementById('grafikChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [
            {
                label: 'Peminjaman',
                data: dataPinjam,
                backgroundColor: 'rgba(99,102,241,0.8)',
                borderRadius: 6,
                borderSkipped: false,
            },
            {
                label: 'Pengembalian',
                data: dataKembali,
                backgroundColor: 'rgba(43,179,192,0.8)',
                borderRadius: 6,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top', labels: { font: { size: 12 }, boxWidth: 12 } },
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
</script>

@endsection
