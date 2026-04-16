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
        $search = $request->input('search');
        $status = $request->input('status');

        $dendasQuery = \App\Models\Denda::with(['peminjaman.buku']);

        if ($search) {
            $dendasQuery->whereHas('peminjaman', function($q) use ($search){
                $q->where('nama_anggota','like',"%{$search}%")
                  ->orWhereHas('buku', function($qb) use ($search){
                      $qb->where('judul','like',"%{$search}%");
                  });
            });
        }

        if ($status) {
            $dendasQuery->where('status', $status);
        }

        $dendas = $dendasQuery->latest()->paginate(10)->withQueryString();

        return view('page.backend.admin.denda.index', compact('dendas'));
    }

    public function bayar($id)
    {
        $denda = \App\Models\Denda::findOrFail($id);
        $denda->update(['status' => 'selesai']);

        return redirect()->route('admin.denda.index')
                         ->with('success', 'Denda berhasil dibayar secara cash');
    }

    public function show($id)
    {
        $denda = \App\Models\Denda::with(['peminjaman.buku'])->findOrFail($id);

        return view('page.backend.admin.denda.show', compact('denda'));
    }
}