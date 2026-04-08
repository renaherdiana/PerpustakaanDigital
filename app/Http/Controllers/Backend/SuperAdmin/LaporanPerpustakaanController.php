<?php

namespace App\Http\Controllers\Backend\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;
use App\Models\Anggota;
use App\Models\User;

class LaporanPerpustakaanController extends Controller
{
    public function index()
    {
        // Ambil data semua
        $buku = Buku::latest()->get();
        $peminjaman = Peminjaman::with('buku','anggota')->latest()->get();
        $pengembalian = Pengembalian::with('peminjaman.buku','peminjaman.anggota')->latest()->get();
        $denda = Denda::with('peminjaman.anggota')->latest()->get();
        $anggota = Anggota::latest()->get();
        // Hitung jumlah untuk card
        $countBuku = $buku->count();
        $countPinjam = $peminjaman->count();
        $countKembali = $pengembalian->count();
        $countDenda = $denda->count();
        $countAnggota = $anggota->count();

        // Kirim ke view
        return view('page.backend.superadmin.laporanperpustakaan.index', compact(
            'buku',
            'peminjaman',
            'pengembalian',
            'denda',
            'anggota',
            'countBuku',
            'countPinjam',
            'countKembali',
            'countDenda',
            'countAnggota'
        ));
    }
}