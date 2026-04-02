@extends('layouts.frontend.app')

@section('content')

<style>

/* ===== BANNER (TIDAK DIUBAH) ===== */

.banner{
background:#4a4e6d;
color:white;
text-align:center;
padding:60px;
margin-bottom:40px;
width:100%;
}

/* ===== CONTAINER ===== */

.katalog-container{
max-width:1200px;
margin:auto;
padding:0 10px;
}

/* ===== FILTER AREA ===== */

.filter{
display:flex;
gap:15px;
margin-bottom:35px;
align-items:center;
background:white;
padding:15px;
border-radius:12px;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

.filter select{
border-radius:8px;
height:42px;
padding:5px 10px;
border:1px solid #ddd;
}

.filter input{
border-radius:8px;
height:42px;
border:1px solid #ddd;
}

/* ===== SLIDER ===== */

.buku-slider{
display:flex;
overflow-x:auto;
gap:22px;
scroll-behavior:smooth;
padding:10px 5px 20px;
}

.buku-slider::-webkit-scrollbar{
display:none;
}

/* ===== CARD ===== */

.card-buku{
min-width:230px;
border-radius:14px;
padding:18px;
text-align:center;
background:white;
transition:0.3s;
border:1px solid #eee;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
}

.card-buku:hover{
transform:translateY(-6px);
box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

/* ===== COVER ===== */

.card-buku img{
width:110px;
height:160px;
object-fit:cover;
border-radius:6px;
margin-bottom:12px;
}

/* ===== JUDUL ===== */

.judul{
font-weight:600;
color:#2c2c2c;
margin-bottom:10px;
font-size:15px;
}

/* ===== DETAIL ===== */

.detail{
font-size:13px;
color:#666;
text-align:left;
margin-top:10px;
}

.detail div{
border-bottom:1px dashed #eee;
padding:5px 0;
}

/* ===== BUTTON PINJAM ===== */

.btn-pinjam{
margin-top:12px;
background:#2bb3c0;
border:none;
padding:7px 20px;
border-radius:20px;
color:white;
font-size:13px;
cursor:pointer;
transition:0.2s;
}

.btn-pinjam:hover{
background:#229aa6;
transform:scale(1.05);
}

/* ===== SLIDER CONTROL ===== */

.slider-control{
display:flex;
justify-content:center;
gap:15px;
margin-top:15px;
}

.slider-btn{
background:#2bb3c0;
border:none;
color:white;
width:42px;
height:42px;
border-radius:50%;
font-size:18px;
cursor:pointer;
transition:0.2s;
}

.slider-btn:hover{
background:#229aa6;
transform:scale(1.1);
}

/* ===== MODAL OVERLAY ===== */

.modal-pinjam{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
backdrop-filter:blur(6px);
justify-content:center;
align-items:center;
z-index:999;
animation:fadeBg 0.3s ease;
}

@keyframes fadeBg{
from{opacity:0;}
to{opacity:1;}
}

/* ===== MODAL CARD ===== */

.modal-content{
background:white;
color:#333;
padding:35px;
border-radius:16px;
width:420px;
text-align:center;
box-shadow:0 10px 40px rgba(0,0,0,0.25);
animation:popup 0.35s ease;
}

@keyframes popup{
from{
transform:translateY(30px) scale(0.95);
opacity:0;
}
to{
transform:translateY(0) scale(1);
opacity:1;
}
}

/* ICON */

.modal-icon{
font-size:40px;
color:#2bb3c0;
margin-bottom:10px;
}

/* ===== INFO BOX ===== */

.modal-info{
background:#f5f7fb;
padding:15px;
border-radius:10px;
text-align:left;
margin:15px 0;
font-size:14px;
border:1px solid #eee;
}

.modal-info p{
margin:6px 0;
}

/* ===== TEXT ===== */

.tanya{
color:#e63946;
font-weight:600;
margin-top:10px;
}

/* ===== BUTTON AREA ===== */

.modal-btn{
display:flex;
justify-content:space-between;
gap:10px;
margin-top:25px;
}

.btn-batal{
flex:1;
background:#d9d9d9;
border:none;
padding:10px;
border-radius:10px;
cursor:pointer;
transition:0.2s;
}

.btn-batal:hover{
background:#c4c4c4;
}

.btn-ajukan{
flex:1;
background:#2bb3c0;
border:none;
padding:10px;
border-radius:10px;
color:white;
cursor:pointer;
text-decoration:none;
transition:0.2s;
}

.btn-ajukan:hover{
background:#2397a2;
transform:scale(1.03);
}

</style>

<div class="banner">
<h2>Katalog Buku</h2>
<small>Home / Katalog Buku</small>
</div>

<div class="katalog-container">

<div class="filter">

<select id="kategoriFilter" class="form-control" style="max-width:200px;">
<option value="">Semua Kategori</option>

@foreach($bukus->pluck('kategori')->unique() as $kategori)

<option value="{{ strtolower($kategori) }}">{{ $kategori }}</option>
@endforeach

</select>

<input type="text" id="searchInput" class="form-control" placeholder="Cari judul buku...">

</div>

<div class="buku-slider" id="slider">

@foreach($bukus as $buku)

<div class="card-buku"
data-judul="{{ strtolower($buku->judul) }}"
data-kategori="{{ strtolower($buku->kategori) }}">

@if($buku->photo) <img src="{{ asset('storage/'.$buku->photo) }}">
@else <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png">
@endif

<div class="judul">{{ $buku->judul }}</div>

<div class="detail">
<div>Penerbit : {{ $buku->penerbit }}</div>
<div>Kategori : {{ $buku->kategori }}</div>
<div>Stok : {{ $buku->stok }}</div>
<div>Status : {{ $buku->status }}</div>
</div>

<button
class="btn-pinjam"
onclick="openModal(
'{{ $buku->id }}',
'{{ $buku->judul }}',
'{{ $buku->penerbit }}',
'{{ $buku->kategori }}',
'{{ $buku->stok }}'
)"
@if($buku->stok == 0)
disabled
style="background:#bfbfbf;cursor:not-allowed;"
@endif

>

Pinjam </button>

</div>

@endforeach

</div>

<div class="slider-control">
<button class="slider-btn" onclick="slideLeft()">❮</button>
<button class="slider-btn" onclick="slideRight()">❯</button>
</div>

</div>

<div id="pinjamModal" class="modal-pinjam">

<div class="modal-content">

<div class="modal-icon">📚</div>

<h3>Ajukan Peminjaman</h3>

<div class="modal-info">
<p><b>Judul Buku :</b> <span id="modalJudul"></span></p>
<p><b>Penerbit :</b> <span id="modalPenerbit"></span></p>
<p><b>Kategori :</b> <span id="modalKategori"></span></p>
</div>

<p class="tanya">Apakah kamu yakin ingin meminjam buku ini?</p>

<div class="modal-btn">

<button class="btn-batal" onclick="closeModal()">Batal</button>

<a id="btnAjukan" href="#" class="btn-ajukan">
Ajukan Peminjaman
</a>

</div>

</div>

</div>

<script>

/* SLIDER */

function slideLeft(){
document.getElementById("slider").scrollBy({
left:-300,
behavior:'smooth'
});
}

function slideRight(){
document.getElementById("slider").scrollBy({
left:300,
behavior:'smooth'
});
}

/* SEARCH + FILTER */

const searchInput = document.getElementById("searchInput");
const kategoriFilter = document.getElementById("kategoriFilter");
const books = document.querySelectorAll(".card-buku");

function filterBooks(){

let search = searchInput.value.toLowerCase();
let kategori = kategoriFilter.value.toLowerCase();

books.forEach(book => {

let judul = book.dataset.judul;
let kat = book.dataset.kategori;

let matchSearch = judul.includes(search);
let matchKategori = kategori === "" || kat.includes(kategori);

if(matchSearch && matchKategori){
book.style.display = "block";
}else{
book.style.display = "none";
}

});

}

searchInput.addEventListener("keyup", filterBooks);
kategoriFilter.addEventListener("change", filterBooks);

/* MODAL */

function openModal(id,judul,penerbit,kategori,stok){

if(stok == 0){
alert("Stok buku habis");
return;
}

document.getElementById("modalJudul").innerText = judul;
document.getElementById("modalPenerbit").innerText = penerbit;
document.getElementById("modalKategori").innerText = kategori;

document.getElementById("btnAjukan").href = "/pinjam/" + id;

document.getElementById("pinjamModal").style.display = "flex";

}

function closeModal(){
document.getElementById("pinjamModal").style.display = "none";
}

/* CLOSE MODAL KLIK LUAR */

window.onclick = function(event){

let modal = document.getElementById("pinjamModal");

if(event.target == modal){
modal.style.display = "none";
}

}

</script>

@endsection
