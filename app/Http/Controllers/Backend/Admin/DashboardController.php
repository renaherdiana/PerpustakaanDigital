<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // total data
        $totalAnggota = Anggota::count();
        $totalBuku = Buku::count();

        // buku yang sedang dipinjam
        $totalPinjam = Peminjaman::where('status','dipinjam')->count();

        // total denda aktif
        $totalDenda = Denda::where('status','!=','selesai')->count();

        // grafik peminjaman per bulan tahun ini
        $grafik = Peminjaman::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total','bulan');

        // buku paling sering dipinjam
        $bukuPopuler = Peminjaman::select('buku_id', DB::raw('COUNT(*) as total_pinjam'))
            ->with('buku')
            ->groupBy('buku_id')
            ->orderByDesc('total_pinjam')
            ->take(5)
            ->get();

        return view('page.backend.admin.dashboard.index', compact(
            'totalAnggota', 'totalBuku', 'totalPinjam',
            'totalDenda', 'grafik', 'bukuPopuler'
        ));
    }
}