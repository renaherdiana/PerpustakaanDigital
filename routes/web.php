<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\Admin\DashboardController;
use App\Http\Controllers\Backend\Admin\DataAnggotaController;
use App\Http\Controllers\Backend\Admin\DataBukuController;
use App\Http\Controllers\Backend\Admin\DendaController;
use App\Http\Controllers\Backend\Admin\LaporanController;
use App\Http\Controllers\Backend\Admin\PeminjamanController;
use App\Http\Controllers\Backend\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Backend\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Backend\Superadmin\LaporanPerpustakaanController;
use App\Http\Controllers\Backend\Superadmin\UserController;
use App\Http\Controllers\Frontend\DendaController as FrontendDendaController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\KatalogController;
use App\Http\Controllers\Frontend\PeminjamansayaController;
use App\Http\Controllers\Frontend\PengembalianController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

// ===============================
// LOGIN UNIVERSAL
// ===============================
Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('login.process');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

// ===============================
// REDIRECT ROOT KE LOGIN
// ===============================
Route::get('/', function(){
    return redirect()->route('login');
});

// ===============================
// FRONTEND ANGGOTA (GUARD 'anggota')

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Katalog Buku
    Route::get('/katalogbuku', [KatalogController::class,'index'])->name('katalog');
    Route::get('/pinjam/{id}', [KatalogController::class,'pinjam'])->name('pinjam.form');
    Route::post('/pinjam/store', [KatalogController::class,'store'])->name('pinjam.store');

    // Peminjaman Saya
    Route::get('/peminjamansaya', [PeminjamansayaController::class,'index'])->name('peminjamansaya');
    Route::get('/peminjamansaya/{id}', [PeminjamansayaController::class,'show'])->name('peminjamansaya.detail');

    // Pengembalian Buku
    Route::post('/ajukan-pengembalian', [PengembalianController::class,'store'])->name('ajukan.pengembalian');

    // Denda
    Route::get('/denda-saya', [FrontendDendaController::class,'index'])->name('frontend.denda');
    Route::get('/denda/bayar/{id}', [FrontendDendaController::class,'bayar'])->name('denda.bayar.form');
    Route::post('/denda/bayar/{id}', [FrontendDendaController::class,'prosesBayar'])->name('bayar.denda');
    Route::get('/denda/detail/{id}', [FrontendDendaController::class,'detail'])->name('denda.detail');

    // Profile Anggota
    Route::get('/profile', [ProfileController::class,'index'])->name('anggota.profile');
    Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class,'update'])->name('profile.update');


// ===============================
// SUPERADMIN (GUARD 'web')
// ===============================
Route::middleware('cekakses:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {

        Route::get('/dashboard', [SuperadminDashboardController::class,'index'])->name('dashboard');

        Route::resource('/datauser', UserController::class);

        Route::get('/laporanperpustakaan', [LaporanPerpustakaanController::class, 'index'])->name('laporan.perpustakaan');

        // PROFILE SUPERADMIN
        Route::get('/profile', [App\Http\Controllers\Backend\Superadmin\ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [App\Http\Controllers\Backend\Superadmin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\Backend\Superadmin\ProfileController::class, 'update'])->name('profile.update');
});

// ===============================
// ADMIN / PETUGAS (GUARD 'web')
// ===============================
Route::middleware('cekakses:petugas')->prefix('admin')->group(function() {

        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.admin');

        Route::resource('anggota', DataAnggotaController::class)->names('admin.anggota');
        Route::resource('databuku', DataBukuController::class)->names('admin.databuku');
        Route::resource('peminjaman', PeminjamanController::class)->names('admin.peminjaman');

        Route::get('/pengembalian', [AdminPengembalianController::class,'index'])->name('admin.pengembalian');
        Route::get('/pengembalian/{id}', [AdminPengembalianController::class,'show'])->name('admin.pengembalian.show');
        Route::post('/pengembalian/verifikasi/{id}', [AdminPengembalianController::class,'verifikasi'])->name('admin.pengembalian.verifikasi');
        Route::post('/pengembalian/tolak/{id}', [AdminPengembalianController::class,'tolak'])->name('admin.pengembalian.tolak');

        Route::get('/denda',[DendaController::class,'index'])->name('admin.denda.index');
        Route::post('/denda/bayar/{id}',[DendaController::class,'bayar'])->name('admin.denda.bayar');
        Route::get('/denda/{id}', [DendaController::class,'show'])->name('admin.denda.show');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');

        Route::get('/admin/profile', [App\Http\Controllers\Backend\Admin\ProfileController::class, 'index'])->name('admin.profile');
        Route::get('/admin/profile/edit', [App\Http\Controllers\Backend\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/admin/profile/update', [App\Http\Controllers\Backend\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
});
