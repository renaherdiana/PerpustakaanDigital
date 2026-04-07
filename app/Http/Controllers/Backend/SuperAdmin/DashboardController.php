<?php

namespace App\Http\Controllers\Backend\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser    = User::count();
        $totalBuku    = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPinjam  = Peminjaman::where('status', 'dipinjam')->count();
        $totalDenda   = Denda::count();

        // Grafik Peminjaman Bulanan
        $grafikPeminjaman = collect();
        for ($i = 1; $i <= 12; $i++) {
            $grafikPeminjaman->push([
                'bulan' => $i,
                'total' => Peminjaman::whereMonth('created_at', $i)->count()
            ]);
        }

        return view('page.backend.superadmin.dashboard.index', compact(
            'totalUser',
            'totalBuku',
            'totalAnggota',
            'totalPinjam',
            'totalDenda',
            'grafikPeminjaman'
        ));
    }
}