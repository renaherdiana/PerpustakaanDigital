<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;

class LaporanController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        $peminjaman = Peminjaman::all();
        $pengembalian = Pengembalian::all();
        $denda = Denda::all();

        // Hitung jumlah
        $countBuku = $buku->count();
        $countPinjam = $peminjaman->count();
        $countKembali = $pengembalian->count();
        $countDenda = $denda->count();

        return view('page.backend.admin.laporan.index', compact(
            'buku',
            'peminjaman',
            'pengembalian',
            'denda',
            'countBuku',
            'countPinjam',
            'countKembali',
            'countDenda'
        ));
    }
}