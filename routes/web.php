<?php

use App\Http\Controllers\Backend\Admin\DashboardController;
use App\Http\Controllers\Backend\Admin\DataAnggotaController;
use App\Http\Controllers\Backend\Admin\DataBukuController;
use App\Http\Controllers\Backend\Admin\DendaController;
use App\Http\Controllers\Backend\Admin\LaporanController;
use App\Http\Controllers\Backend\Admin\PeminjamanController;
use App\Http\Controllers\Backend\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Backend\Superadmin\LaporanPerpustakaanController;
use App\Http\Controllers\Backend\Superadmin\UserController;
use App\Http\Controllers\Frontend\DendaController as FrontendDendaController;
use App\Http\Controllers\Frontend\KatalogController;
use App\Http\Controllers\Frontend\PeminjamansayaController;
use App\Http\Controllers\Frontend\PengembalianController;
use Illuminate\Support\Facades\Route;

//FRONTEND (ANGGOTA)

Route::get('/', function () {
    return view('page.frontend.home.index');
})->name('home');

//KATALOG BUKU
Route::get('/katalogbuku', [KatalogController::class, 'index'])->name('katalog');
Route::get('/pinjam/{id}', [KatalogController::class,'pinjam'])->name('pinjam.form');
Route::post('/pinjam/store', [KatalogController::class,'store'])->name('pinjam.store');


//PEMINJAMAN SAYA
Route::get('/peminjamansaya', [PeminjamansayaController::class, 'index'])->name('peminjamansaya');
Route::get('/peminjamansaya/{id}', [PeminjamansayaController::class, 'show'])->name('peminjamansaya.detail');


//AJUKAN PENGEMBALIAN
Route::post('/ajukan-pengembalian',[PengembalianController::class,'store'])->name('ajukan.pengembalian');

//DENDA ANGGOTA
Route::get('/denda-saya', [FrontendDendaController::class,'index'])->name('frontend.denda');
Route::get('/denda/bayar/{id}',[FrontendDendaController::class,'bayar'])->name('denda.bayar.form');
Route::post('/denda/bayar/{id}',[FrontendDendaController::class,'prosesBayar'])->name('bayar.denda');
Route::get('/denda/detail/{id}', [\App\Http\Controllers\Frontend\DendaController::class,'detail'])->name('denda.detail');

//SUPER ADMIN (KEPALA PERPUSTAKAAN)

Route::prefix('superadmin')->name('superadmin.')->group(function () {

    //DASHBOARD
    Route::get('/dashboard', function () {
        return view('page.backend.superadmin.dashboard.index');
    })->name('dashboard');

    //DATA USER (PETUGAS)
    Route::resource('datauser', UserController::class);

    //LAPORAN PERPUSTAKAAN
     Route::get('/laporanperpustakaan', [LaporanPerpustakaanController::class, 'index'])->name('laporan.perpustakaan');
});

//ADMIN (PETUGAS)

Route::prefix('admin')->name('admin.')->group(function () {

    //DASHBOARD
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

    //DATA ANGGOTA
    Route::resource('anggota', DataAnggotaController::class);
    
    //DATA BUKU
    Route::resource('databuku', DataBukuController::class);

    //PEMINJAMAN
    Route::resource('peminjaman', PeminjamanController::class);

    //PENGEMBALIAN
    Route::get('/pengembalian', [AdminPengembalianController::class,'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{id}', [AdminPengembalianController::class,'show'])->name('pengembalian.show');
    Route::post('/pengembalian/verifikasi/{id}', [AdminPengembalianController::class,'verifikasi'])->name('pengembalian.verifikasi');

    //DENDA
    Route::get('/denda',[DendaController::class,'index'])->name('denda.index');
    Route::post('/denda/bayar/{id}',[DendaController::class,'bayar'])->name('denda.bayar');
    Route::get('/denda/{id}', [DendaController::class,'show'])->name('denda.show');

    //LAPORAN
     Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');

});