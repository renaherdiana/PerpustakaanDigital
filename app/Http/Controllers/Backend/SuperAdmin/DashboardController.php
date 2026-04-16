<?php

namespace App\Http\Controllers\Backend\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Pengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser      = User::count();
        $totalBuku      = Buku::count();
        $totalAnggota   = Anggota::count();
        $totalPinjam    = Peminjaman::where('status', 'dipinjam')->count();
        $totalDenda     = Denda::where('status', '!=', 'selesai')->count();
        $totalSelesai   = Peminjaman::where('status', 'selesai')->count();

        // Grafik peminjaman per bulan (tahun ini)
        $grafikPeminjaman = collect();
        for ($i = 1; $i <= 12; $i++) {
            $grafikPeminjaman->push([
                'bulan' => $i,
                'total' => Peminjaman::whereMonth('created_at', $i)
                                     ->whereYear('created_at', date('Y'))
                                     ->count()
            ]);
        }

        // Grafik pengembalian per bulan (tahun ini)
        $grafikPengembalian = collect();
        for ($i = 1; $i <= 12; $i++) {
            $grafikPengembalian->push([
                'bulan' => $i,
                'total' => Pengembalian::whereMonth('created_at', $i)
                                        ->whereYear('created_at', date('Y'))
                                        ->count()
            ]);
        }

        // Denda tertinggi
        $dendaTertinggi = Denda::with('peminjaman')
            ->orderBy('denda', 'DESC')
            ->take(5)
            ->get();

        return view('page.backend.superadmin.dashboard.index', compact(
            'totalUser', 'totalBuku', 'totalAnggota',
            'totalPinjam', 'totalDenda', 'totalSelesai',
            'grafikPeminjaman', 'grafikPengembalian', 'dendaTertinggi'
        ));
    }
}