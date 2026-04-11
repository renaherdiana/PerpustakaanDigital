@extends('layouts.backend.admin.app')

@section('content')

<style>
.dash-greeting { margin-bottom: 24px; }
.dash-greeting h4 { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
.dash-greeting p  { color: #94a3b8; font-size: 14px; }

/* STAT CARDS */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    border-radius: 16px;
    padding: 20px 18px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    transition: 0.3s;
    background: white;
    border: 1px solid #f1f5f9;
}

.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }

.stat-icon-box {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.ic-purple { background: #f0eeff; }
.ic-teal   { background: #e8f9fb; }
.ic-orange { background: #fff7ed; }
.ic-red    { background: #fff1f2; }

.stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; margin-bottom: 4px; }
.stat-value { font-size: 26px; font-weight: 700; color: #1e293b; line-height: 1; }

/* BOTTOM GRID */
.bottom-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.chart-card, .populer-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    padding: 24px;
    border: 1px solid #f1f5f9;
}

.card-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* BUKU POPULER */
.buku-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f8fafc;
}
.buku-item:last-child { border-bottom: none; }

.buku-rank {
    width: 28px; height: 28px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    flex-shrink: 0;
}
.rank-1 { background: #fef3c7; color: #92400e; }
.rank-2 { background: #f1f5f9; color: #475569; }
.rank-3 { background: #fff7ed; color: #9a3412; }
.rank-other { background: #f8fafc; color: #94a3b8; }

.buku-info { flex: 1; min-width: 0; }
.buku-judul { font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.buku-count { font-size: 11px; color: #94a3b8; margin-top: 2px; }

.buku-bar-wrap { width: 60px; }
.buku-bar-bg { background: #f1f5f9; border-radius: 4px; height: 6px; }
.buku-bar-fill { background: #6366f1; border-radius: 4px; height: 6px; }
</style>

@php
    $user = Auth::guard('web')->check() ? Auth::guard('web')->user() : null;
    $nama = $user ? ($user->name ?? $user->nama) : 'Petugas';
    $maxPinjam = $bukuPopuler->max('total_pinjam') ?: 1;
@endphp

<div class="dash-greeting">
    <h4>Halo, {{ $nama }} 👋</h4>
    <p>Selamat datang di dashboard E-Library SMKN 3 Banjar</p>
</div>

<!-- STAT CARDS -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon-box ic-purple">👥</div>
        <div>
            <div class="stat-label">Total Anggota</div>
            <div class="stat-value">{{ $totalAnggota }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-box ic-teal">📚</div>
        <div>
            <div class="stat-label">Total Buku</div>
            <div class="stat-value">{{ $totalBuku }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-box ic-orange">📖</div>
        <div>
            <div class="stat-label">Sedang Dipinjam</div>
            <div class="stat-value">{{ $totalPinjam }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-box ic-red">💰</div>
        <div>
            <div class="stat-label">Denda Aktif</div>
            <div class="stat-value">{{ $totalDenda }}</div>
        </div>
    </div>
</div>

<!-- GRAFIK + BUKU POPULER -->
<div class="bottom-grid">

    <div class="chart-card">
        <div class="card-title">📊 Grafik Peminjaman {{ date('Y') }}</div>
        <canvas id="grafikPeminjaman" height="120"></canvas>
    </div>

    <div class="populer-card">
        <div class="card-title">🔥 Buku Paling Sering Dipinjam</div>
        @forelse($bukuPopuler as $i => $item)
        @php $pct = round(($item->total_pinjam / $maxPinjam) * 100); @endphp
        <div class="buku-item">
            <div class="buku-rank {{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : 'rank-other')) }}">
                {{ $i + 1 }}
            </div>
            <div class="buku-info">
                <div class="buku-judul">{{ $item->buku->judul ?? '-' }}</div>
                <div class="buku-count">{{ $item->total_pinjam }}x dipinjam</div>
            </div>
            <div class="buku-bar-wrap">
                <div class="buku-bar-bg">
                    <div class="buku-bar-fill" style="width:{{ $pct }}%"></div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center; color:#aaa; padding:20px 0; font-size:13px;">Belum ada data</div>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikPeminjaman').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(99,102,241,0.3)');
gradient.addColorStop(1, 'rgba(99,102,241,0.02)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Peminjaman',
            data: [
                {{ $grafik[1] ?? 0 }}, {{ $grafik[2] ?? 0 }}, {{ $grafik[3] ?? 0 }},
                {{ $grafik[4] ?? 0 }}, {{ $grafik[5] ?? 0 }}, {{ $grafik[6] ?? 0 }},
                {{ $grafik[7] ?? 0 }}, {{ $grafik[8] ?? 0 }}, {{ $grafik[9] ?? 0 }},
                {{ $grafik[10] ?? 0 }}, {{ $grafik[11] ?? 0 }}, {{ $grafik[12] ?? 0 }}
            ],
            borderColor: '#6366f1',
            backgroundColor: gradient,
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#6366f1',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { backgroundColor: '#1e293b', padding: 10, cornerRadius: 8 }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
</script>

@endsection
