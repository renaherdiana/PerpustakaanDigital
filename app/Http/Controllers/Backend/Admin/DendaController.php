<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    /**
     * Menampilkan halaman daftar denda dengan pagination
     */
    public function index(Request $request)
    {
        // Ambil query search (opsional)
        $search = $request->input('search');

        // Ambil data pengembalian yang memiliki denda + relasi buku dan peminjaman
        $dendasQuery = Pengembalian::with([
            'peminjaman',
            'peminjaman.buku',
            'denda'
        ])->whereHas('denda');

        $status = $request->input('status');

        // Filter search
        if ($search) {
            $dendasQuery->whereHas('peminjaman', function($q) use ($search){
                $q->where('nama_anggota','like',"%{$search}%")
                  ->orWhereHas('buku', function($qb) use ($search){
                      $qb->where('judul','like',"%{$search}%");
                  });
            });
        }

        // Filter status
        if ($status) {
            $dendasQuery->whereHas('denda', function($q) use ($status){
                $q->where('status', $status);
            });
        }

        // Pagination 10 data per halaman
        $dendas = $dendasQuery->latest()->paginate(10)->withQueryString();

        return view('page.backend.admin.denda.index', compact('dendas'));
    }

    /**
     * Verifikasi pembayaran denda (CASH)
     */
    public function bayar($id)
    {
        $pengembalian = Pengembalian::with('denda')->findOrFail($id);

        if ($pengembalian->denda) {
            $pengembalian->denda->update([
                'status' => 'selesai', // sudah dibayar
            ]);
        }

        return redirect()->route('admin.denda.index')
                         ->with('success', 'Denda berhasil dibayar secara cash');
    }

    /**
     * Menampilkan detail denda
     */
    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman',
            'peminjaman.buku',
            'denda'
        ])->findOrFail($id);

        // Hitung total denda untuk tampilan (opsional)
        $terlambat = $pengembalian->denda->hari_terlambat ?? 0;
        $jumlahBuku = $pengembalian->peminjaman->jumlah ?? 1;
        $dendaPerBukuPerHari = 1000;
        $totalDenda = $terlambat * $jumlahBuku * $dendaPerBukuPerHari;

        return view('page.backend.admin.denda.show', compact('pengembalian','totalDenda'));
    }
}