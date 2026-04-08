@extends('layouts.backend.admin.app')

@section('content')

<style>

/* HEADER */
.header h4{
font-weight:600;
}

/* CARD */
.card-soft{
border:1px solid #f1f1f1;
border-radius:12px;
}

.bg-soft-anggota{background:#f3f1ff;}
.bg-soft-buku{background:#eef9ff;}
.bg-soft-pinjam{background:#fff6e9;}
.bg-soft-denda{background:#ffecec;}

.card-soft h6{
color:#666;
font-weight:500;
}

.card-soft h3{
font-weight:700;
}

.card-icon{
font-size:26px;
margin-bottom:6px;
}

</style>


<div class="header mb-4">
<h4 class="gradient-text">Hallo Rena Herdiana 👋</h4>
<p class="text-muted">Selamat Datang di Sistem Perpustakaan Digital</p>
</div>


<div class="row g-3">

<!-- TOTAL ANGGOTA -->
<div class="col-md-3">
<div class="card card-soft bg-soft-anggota shadow-sm">
<div class="card-body text-center">
<div class="card-icon">👥</div>
<h6>Total Anggota</h6>
<h3>{{ $totalAnggota }}</h3>
</div>
</div>
</div>

<!-- TOTAL BUKU -->
<div class="col-md-3">
<div class="card card-soft bg-soft-buku shadow-sm">
<div class="card-body text-center">
<div class="card-icon">📚</div>
<h6>Total Buku</h6>
<h3>{{ $totalBuku }}</h3>
</div>
</div>
</div>

<!-- BUKU DIPINJAM -->
<div class="col-md-3">
<div class="card card-soft bg-soft-pinjam shadow-sm">
<div class="card-body text-center">
<div class="card-icon">📖</div>
<h6>Buku Dipinjam</h6>
<h3>{{ $totalPinjam }}</h3>
</div>
</div>
</div>

<!-- TOTAL DENDA -->
<div class="col-md-3">
<div class="card card-soft bg-soft-denda shadow-sm">
<div class="card-body text-center">
<div class="card-icon">💰</div>
<h6>Total Denda</h6>
<h3>{{ $totalDenda }}</h3>
</div>
</div>
</div>

</div>


<!-- GRAFIK PEMINJAMAN -->
<div class="card mt-4 shadow-sm card-soft">
<div class="card-body">

<h5 class="mb-4">Grafik Peminjaman Buku</h5>

<canvas id="grafikPeminjaman" height="100"></canvas>

</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('grafikPeminjaman').getContext('2d');

const gradient = ctx.createLinearGradient(0,0,0,350);
gradient.addColorStop(0,"rgba(99,102,241,0.4)");
gradient.addColorStop(1,"rgba(99,102,241,0.05)");

new Chart(ctx,{
type:'line',
data:{
labels:[
'Jan','Feb','Mar','Apr','Mei','Jun',
'Jul','Ags','Sep','Okt','Nov','Des'
],
datasets:[{
label:'Jumlah Peminjaman',
data:[
{{ $grafik[1] ?? 0 }},
{{ $grafik[2] ?? 0 }},
{{ $grafik[3] ?? 0 }},
{{ $grafik[4] ?? 0 }},
{{ $grafik[5] ?? 0 }},
{{ $grafik[6] ?? 0 }},
{{ $grafik[7] ?? 0 }},
{{ $grafik[8] ?? 0 }},
{{ $grafik[9] ?? 0 }},
{{ $grafik[10] ?? 0 }},
{{ $grafik[11] ?? 0 }},
{{ $grafik[12] ?? 0 }}
],
borderColor:"#6366f1",
backgroundColor:gradient,
borderWidth:3,
fill:true,
tension:0.4,
pointBackgroundColor:"#6366f1",
pointBorderColor:"#ffffff",
pointBorderWidth:3,
pointRadius:6,
pointHoverRadius:8
}]
},

options:{
responsive:true,
plugins:{
legend:{
display:false
},
tooltip:{
backgroundColor:"#111827",
padding:12,
cornerRadius:8
}
},
scales:{
y:{
beginAtZero:true,
ticks:{
maxTicksLimit:6
},
grid:{
color:"rgba(0,0,0,0.05)"
}
},
x:{
grid:{
display:false
}
}
}
}

});

</script>

@endsection