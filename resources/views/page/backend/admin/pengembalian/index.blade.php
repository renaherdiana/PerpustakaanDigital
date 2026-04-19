@extends('layouts.backend.admin.app')

@section('content')

<style>
/* --- CARD & TITLE --- */
.page-title{
    font-weight:700;
    font-size:20px;
    margin-bottom:22px;
    color:#1e293b;
}
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

/* --- BUTTON --- */
.btn-action{
    border:none;
    border-radius:8px;
    font-size:13px;
    padding:6px 14px;
    cursor:pointer;
    transition:0.2s;
}
.btn-verify{
    background:#dcfce7;
    color:#16a34a;
    box-shadow:none;
}
.btn-verify:hover{ background:#bbf7d0; }
.btn-tolak{
    background:#fee2e2;
    color:#dc2626;
    box-shadow:none;
}
.btn-tolak:hover{ background:#fecaca; }

/* --- BADGE --- */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}
.badge-wait{ background:#fef3c7; color:#92400e; }
.badge-done{ background:#d1fae5; color:#065f46; }

/* --- ICON BUTTON --- */
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
.icon-show{
    background:#ecfdf5;
    color:#059669;
}

/* --- POPUP --- */
.popup-bg{
    position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    display:none; align-items:center; justify-content:center; z-index:999;
    padding:20px;
}
.popup-box{
    background:white; width:450px;
    border-radius:16px; padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
    text-align:left;
    position:relative;
    animation:fadeIn 0.3s ease-out;
}
@keyframes fadeIn{
    from{opacity:0; transform:translateY(-20px);}
    to{opacity:1; transform:translateY(0);}
}
.popup-title{
    font-weight:700; font-size:22px; margin-bottom:25px; text-align:center;
    color:#1e293b;
}
.popup-data{
    margin:12px 0; font-size:15px; display:flex; justify-content:space-between;
    border-bottom:1px solid #e5e7eb; padding-bottom:6px;
}
.popup-data b{
    width:140px; color:#334155; font-weight:600;
}
.popup-data span{
    font-weight:500; color:#1f2937;
}
.popup-total{
    font-size:18px; font-weight:700; margin-top:15px; text-align:right;
}
.popup-total.red{
    color:#dc2626;
}
.popup-btn{
    display:flex; justify-content:flex-end; gap:10px; margin-top:25px;
}
.btn-batal{
    background:#e5e7eb; border:none; padding:8px 18px; border-radius:8px;
    font-weight:600; cursor:pointer;
}
.btn-verif-popup{
    background:#16a34a; border:none; padding:8px 18px; border-radius:8px; color:white;
    font-weight:600; cursor:pointer;
}
.popup-close{
    position:absolute; top:10px; right:12px; font-size:20px; cursor:pointer; color:#6b7280;
    transition:0.2s;
}
.popup-close:hover{ color:#111827; }

/* --- PAGINATION MIRIP DATA BUKU --- */
.pagination{
    display:flex;
    list-style:none;
    gap:4px;
    justify-content:end;
    margin-top:15px;
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

<h5 class="page-title">Data Pengembalian</h5>

<div class="filter-area">
<div class="filter-left">
<input type="text" id="searchInput" placeholder="Cari anggota / buku">
<select id="statusFilter">
<option value="">Semua Status</option>
<option value="menunggu_verifikasi">Menunggu Verifikasi</option>
<option value="dikembalikan">Dikembalikan</option>
</select>
</div>
</div>

<div class="table-responsive">
<table class="table align-middle" id="pengembalianTable">
<thead>
<tr>
<th>No</th>
<th>Nama Anggota</th>
<th>Judul Buku</th>
<th>Jumlah Pinjam</th>
<th>Tgl Dikembalikan</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@forelse($pengembalian as $no => $data)
<tr data-status="{{ $data->status }}">
<td>{{ $pengembalian->firstItem() + $no }}</td>
<td>{{ $data->peminjaman->nama_anggota }}</td>
<td>{{ optional($data->peminjaman->buku)->judul }}</td>
<td>{{ $data->peminjaman->jumlah }}</td>
<td>{{ $data->tgl_dikembalikan ? \Carbon\Carbon::parse($data->tgl_dikembalikan)->format('Y-m-d') : '-' }}</td>
<td>
@if($data->status == 'menunggu_verifikasi')
<span class="badge badge-wait"><i class="bi bi-clock"></i> Menunggu Verifikasi</span>
@else
<span class="badge badge-done"><i class="bi bi-check-circle"></i> Dikembalikan</span>
@endif
</td>
<td>
@if($data->status == 'menunggu_verifikasi')
<div style="display:flex;gap:6px;">
<button class="btn-action btn-verify icon-btn"
    data-id="{{ $data->id }}"
    data-nama="{{ $data->peminjaman->nama_anggota }}"
    data-judul="{{ optional($data->peminjaman->buku)->judul }}"
    data-jumlah="{{ $data->peminjaman->jumlah }}"
    data-denda="{{ $data->denda }}"
    data-tgl_kembali="{{ $data->peminjaman->tgl_kembali }}"
    title="Terima">
    <i class="bi bi-check-lg"></i>
</button>
<button class="btn-action btn-tolak icon-btn"
    onclick="openPopupTolak('{{ $data->id }}','{{ $data->peminjaman->nama_anggota }}','{{ optional($data->peminjaman->buku)->harga ?? 0 }}')"
    title="Tolak">
    <i class="bi bi-x-lg"></i>
</button>
</div>
@else
<a href="{{ route('admin.pengembalian.show',$data->id) }}" class="icon-btn icon-show">
<i class="bi bi-eye"></i>
</a>
@endif
</td>
</tr>
@empty
<tr>
<td colspan="7" style="text-align:center;padding:25px;">Belum ada data pengembalian</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- PAGINATION -->
@if($pengembalian->lastPage() > 1)
<ul class="pagination">
    <li class="page-item {{ $pengembalian->currentPage() == 1 ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $pengembalian->url($pengembalian->currentPage()-1) }}">Previous</a>
    </li>
    @for($i=1; $i<=$pengembalian->lastPage(); $i++)
        @if($i == 1 || $i == $pengembalian->lastPage() || ($i >= $pengembalian->currentPage()-2 && $i <= $pengembalian->currentPage()+2))
            <li class="page-item {{ $i == $pengembalian->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $pengembalian->url($i) }}">{{ $i }}</a>
            </li>
        @elseif($i == 2 && $pengembalian->currentPage() > 4)
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @elseif($i == $pengembalian->lastPage()-1 && $pengembalian->currentPage() < $pengembalian->lastPage()-3)
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif
    @endfor
    <li class="page-item {{ $pengembalian->currentPage() == $pengembalian->lastPage() ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $pengembalian->url($pengembalian->currentPage()+1) }}">Next</a>
    </li>
</ul>
@endif

</div>
</div>

<!-- POPUP TOLAK -->
<div class="popup-bg" id="popupTolak">
<div class="popup-box">
<span class="popup-close" onclick="closePopupTolak()">&times;</span>
<h4 class="popup-title">Tolak Pengembalian</h4>
<div class="popup-data"><b>Nama Anggota:</b> <span id="tolakNama"></span></div>
<form id="formTolak" method="POST">
@csrf
<div style="margin-top:16px;">
<label style="font-weight:600;font-size:14px;color:#334155;">Alasan Penolakan <span style="color:red">*</span></label>
<textarea name="alasan_ditolak" rows="3" required
    style="width:100%;margin-top:8px;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;resize:none;"
    placeholder="Tulis alasan penolakan..."></textarea>
</div>
<div style="margin-top:14px;">
<label style="display:flex;align-items:center;gap:8px;font-weight:600;font-size:14px;color:#334155;cursor:pointer;">
    <input type="checkbox" id="cbKerusakan" onchange="toggleDendaKerusakan(this)" style="width:16px;height:16px;">
    Ada kerusakan buku
</label>
</div>
<div id="dendaKerusakanBox" style="display:none;margin-top:12px;">
<label style="font-weight:600;font-size:14px;color:#334155;">Nominal Denda Kerusakan (Rp) <span style="color:red">*</span></label>
<input type="number" name="denda_kerusakan" id="inputDendaKerusakan" min="0" placeholder="Contoh: 50000"
    style="width:100%;margin-top:8px;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;">
</div>
<div style="margin-top:14px;">
<label style="display:flex;align-items:center;gap:8px;font-weight:600;font-size:14px;color:#334155;cursor:pointer;">
    <input type="checkbox" id="cbHilang" onchange="toggleDendaHilang(this)" style="width:16px;height:16px;">
    Buku hilang
</label>
</div>
<div id="dendaHilangBox" style="display:none;margin-top:12px;">
<label style="font-weight:600;font-size:14px;color:#334155;">Nominal Denda Kehilangan (Rp) <span style="color:red">*</span></label>
<input type="number" name="denda_hilang" id="inputDendaHilang" min="0"
    style="width:100%;margin-top:8px;padding:10px;border-radius:8px;border:1px solid #e2e8f0;font-size:14px;">
</div>
<div class="popup-btn">
<button type="button" class="btn-batal" onclick="closePopupTolak()">Batal</button>
<button type="submit" style="background:#dc2626;border:none;padding:8px 18px;border-radius:8px;color:white;font-weight:600;cursor:pointer;">Tolak</button>
</div>
</form>
</div>
</div>

<!-- POPUP ADMIN -->
<div class="popup-bg" id="popupForm">
<div class="popup-box">
<span class="popup-close" onclick="closePopup()">&times;</span>
<h4 class="popup-title">Verifikasi Pengembalian</h4>
<div class="popup-data"><b>Nama Anggota:</b> <span id="popupNama"></span></div>
<div class="popup-data"><b>Judul Buku:</b> <span id="popupJudul"></span></div>
<div class="popup-data"><b>Jumlah Pinjam:</b> <span id="popupJumlah"></span></div>
<div class="popup-data"><b>Hari Terlambat:</b> <span id="popupTelat"></span></div>
<div class="popup-total" id="popupTotalDenda"></div>
<form id="formVerif" method="POST">
@csrf
<input type="hidden" name="peminjaman_id" id="peminjaman_id">
<div class="popup-btn">
<button type="button" class="btn-batal" onclick="closePopup()">Batal</button>
<button type="submit" class="btn-verif-popup">Verifikasi</button>
</div>
</form>
</div>
</div>

<script>
// FILTER
const searchInput=document.getElementById("searchInput");
const statusFilter=document.getElementById("statusFilter");
const table=document.getElementById("pengembalianTable");
const rows=table.getElementsByTagName("tr");
searchInput.addEventListener("keyup",filterTable);
statusFilter.addEventListener("change",filterTable);
function filterTable(){
    const searchValue=searchInput.value.toLowerCase();
    const statusValue=statusFilter.value.toLowerCase();
    for(let i=1;i<rows.length;i++){
        const anggota=rows[i].cells[1]?.textContent.toLowerCase();
        const buku=rows[i].cells[2]?.textContent.toLowerCase();
        const status=rows[i].dataset.status ?? '';
        rows[i].style.display=(anggota.includes(searchValue)||buku.includes(searchValue)) && (statusValue===""||status===statusValue) ? "" : "none";
    }
}

// POPUP
document.querySelectorAll('.btn-verify').forEach(btn => {
    btn.addEventListener('click', function(){
        const id      = this.dataset.id;
        const nama    = this.dataset.nama;
        const judul   = this.dataset.judul;
        const jumlah  = parseInt(this.dataset.jumlah);
        const tglKembali = this.dataset.tgl_kembali;

        document.getElementById('popupForm').style.display='flex';
        document.getElementById('peminjaman_id').value = id;
        document.getElementById('popupNama').innerText = nama;
        document.getElementById('popupJudul').innerText = judul;
        document.getElementById('popupJumlah').innerText = jumlah;

        // Hitung hari terlambat
        let hariTelat = 0;
        if(tglKembali){
            const tglSekarang = new Date();
            const tglHarusKembali = new Date(tglKembali);
            const diffTime = tglSekarang - tglHarusKembali;
            hariTelat = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            if(hariTelat < 0) hariTelat = 0;
        }
        document.getElementById('popupTelat').innerText = hariTelat + ' Hari';

        // Total denda per hari 1000 per buku
        const totalDenda = hariTelat * jumlah * 1000;
        const totalDendaElem = document.getElementById('popupTotalDenda');
        totalDendaElem.innerText = 'Total Denda: Rp ' + totalDenda.toLocaleString();
        if(totalDenda > 0){
            totalDendaElem.classList.add('red');
        } else {
            totalDendaElem.classList.remove('red');
        }

        const route="{{ route('admin.pengembalian.verifikasi', ':id') }}".replace(':id', id);
        document.getElementById('formVerif').action = route;
    });
});

// CLOSE POPUP
function closePopup(){
    document.getElementById('popupForm').style.display='none';
}

// CLOSE POPUP ESC key
document.addEventListener('keydown', function(e){
    if(e.key === "Escape"){ closePopup(); closePopupTolak(); }
});

// POPUP TOLAK
let hargaBukuAktif = 0;
function openPopupTolak(id, nama, harga){
    hargaBukuAktif = parseInt(harga) || 0;
    document.getElementById('popupTolak').style.display='flex';
    document.getElementById('tolakNama').innerText = nama;
    const route = "{{ route('admin.pengembalian.tolak', ':id') }}".replace(':id', id);
    document.getElementById('formTolak').action = route;
}
function closePopupTolak(){
    document.getElementById('popupTolak').style.display='none';
    document.getElementById('formTolak').querySelector('textarea').value='';
    document.getElementById('cbKerusakan').checked = false;
    document.getElementById('dendaKerusakanBox').style.display = 'none';
    document.getElementById('inputDendaKerusakan').value = '';
    document.getElementById('inputDendaKerusakan').removeAttribute('required');
    document.getElementById('cbHilang').checked = false;
    document.getElementById('dendaHilangBox').style.display = 'none';
    document.getElementById('inputDendaHilang').value = '';
    document.getElementById('inputDendaHilang').removeAttribute('required');
}

function toggleDendaKerusakan(cb){
    const box = document.getElementById('dendaKerusakanBox');
    const input = document.getElementById('inputDendaKerusakan');
    if(cb.checked){
        box.style.display = 'block';
        input.setAttribute('required','required');
    } else {
        box.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
    }
}

function toggleDendaHilang(cb){
    const box = document.getElementById('dendaHilangBox');
    const input = document.getElementById('inputDendaHilang');
    if(cb.checked){
        box.style.display = 'block';
        input.setAttribute('required','required');
        input.value = hargaBukuAktif;
    } else {
        box.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
    }
}
</script>

@endsection