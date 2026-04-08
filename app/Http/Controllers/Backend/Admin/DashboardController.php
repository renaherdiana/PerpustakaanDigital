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

        // total denda
        $totalDenda = Denda::count();

        // grafik peminjaman per bulan
        $grafik = Peminjaman::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total','bulan');

        return view('page.backend.admin.dashboard.index', compact(
            'totalAnggota',
            'totalBuku',
            'totalPinjam',
            'totalDenda',
            'grafik'
        ));
    }
}