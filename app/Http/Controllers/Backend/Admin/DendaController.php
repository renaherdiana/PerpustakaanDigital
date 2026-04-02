<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    /**
     * Menampilkan halaman daftar denda
     */
    public function index()
    {
        // Ambil data pengembalian yang memiliki denda
        $dendas = Pengembalian::with([
                    'peminjaman',
                    'peminjaman.buku',
                    'denda'
                ])
                ->whereHas('denda')
                ->get();

        return view('page.backend.admin.denda.index', compact('dendas'));
    }


    /**
     * Verifikasi pembayaran denda (CASH)
     * Admin klik tombol setelah menerima uang
     */
    public function bayar($id)
    {
        // Ambil data pengembalian
        $pengembalian = Pengembalian::with('denda')->findOrFail($id);

        // Jika ada denda
        if ($pengembalian->denda) {

            $pengembalian->denda->update([
                'status' => 'selesai' // artinya sudah dibayar
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
        // Ambil data pengembalian + relasi
        $pengembalian = Pengembalian::with([
            'peminjaman',
            'peminjaman.buku',
            'denda'
        ])->findOrFail($id);

        return view('page.backend.admin.denda.show', compact('pengembalian'));
    }
}