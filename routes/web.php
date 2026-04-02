<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Backend\Admin\DataBukuController;
use App\Http\Controllers\Backend\Admin\DendaController;
use App\Http\Controllers\Backend\Admin\PeminjamanController;
use App\Http\Controllers\Backend\Admin\PengembalianController as AdminPengembalianController;

use App\Http\Controllers\Frontend\KatalogController;
use App\Http\Controllers\Frontend\PeminjamansayaController;
use App\Http\Controllers\Frontend\PengembalianController;
use App\Http\Controllers\Frontend\DendaController as FrontendDendaController;


/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('page.frontend.home.index');
})->name('home');


/* ===============================
KATALOG BUKU
=============================== */

Route::get('/katalogbuku', [KatalogController::class, 'index'])->name('katalog');

Route::get('/pinjam/{id}', [KatalogController::class,'pinjam'])->name('pinjam.form');

Route::post('/pinjam/store', [KatalogController::class,'store'])->name('pinjam.store');


/* ===============================
PEMINJAMAN SAYA
=============================== */

Route::get('/peminjamansaya', [PeminjamansayaController::class, 'index'])->name('peminjamansaya');

Route::get('/peminjamansaya/{id}', [PeminjamansayaController::class, 'show'])->name('peminjamansaya.detail');


/* ===============================
AJUKAN PENGEMBALIAN
=============================== */

Route::post('/ajukan-pengembalian',[PengembalianController::class,'store'])->name('ajukan.pengembalian');


/* ===============================
HALAMAN DENDA USER
=============================== */

Route::get('/denda-saya', [FrontendDendaController::class,'index'])->name('frontend.denda');
Route::get('/denda/bayar/{id}',[FrontendDendaController::class,'bayar'])->name('denda.bayar.form');
Route::post('/denda/bayar/{id}',[FrontendDendaController::class,'prosesBayar'])->name('bayar.denda');
Route::get('/denda/detail/{id}', [\App\Http\Controllers\Frontend\DendaController::class,'detail'])->name('denda.detail');



/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('superadmin')->group(function () {

    Route::get('/dashboard', function () {
        return view('page.backend.superadmin.dashboard.index');
    });

    Route::get('/datauser', function () {
        return view('page.backend.superadmin.datauser.index');
    });

    Route::get('/laporanperpustakaan', function () {
        return view('page.backend.superadmin.laporanperpustakaan.index');
    });

    Route::get('/laporananggota', function () {
        return view('page.backend.superadmin.laporananggota.index');
    });

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('page.backend.admin.dashboard.index');
    });

    Route::get('/dataanggota', function () {
        return view('page.backend.admin.dataanggota.index');
    });


    /* ===============================
    DATA BUKU
    =============================== */

    Route::resource('databuku', DataBukuController::class);


    /* ===============================
    PEMINJAMAN
    =============================== */

    Route::resource('peminjaman', PeminjamanController::class);


    /* ===============================
    PENGEMBALIAN
    =============================== */

    Route::get('/pengembalian', [AdminPengembalianController::class,'index'])->name('pengembalian.index');

    Route::get('/pengembalian/{id}', [AdminPengembalianController::class,'show'])->name('pengembalian.show');

    Route::post('/pengembalian/verifikasi/{id}', [AdminPengembalianController::class,'verifikasi'])->name('pengembalian.verifikasi');


    /* ===============================
    DENDA
    =============================== */

    Route::get('/denda',[DendaController::class,'index'])->name('denda.index');

    Route::post('/denda/bayar/{id}',[DendaController::class,'bayar'])->name('denda.bayar');

    Route::get('/denda/{id}', [DendaController::class,'show'])->name('denda.show');


    /* ===============================
    LAPORAN
    =============================== */

    Route::get('/laporan', function () {
        return view('page.backend.admin.laporan.index');
    });

});