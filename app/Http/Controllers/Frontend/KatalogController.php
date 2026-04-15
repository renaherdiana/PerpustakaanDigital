<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KatalogController extends Controller
{

    // HALAMAN KATALOG
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->search) {
            $query->where('judul', 'like', '%'.$request->search.'%');
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $bukus = $query->latest()->get();
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        return view('page.frontend.katalogbuku.index', compact('bukus', 'kategoris'));
    }


    // HALAMAN FORM PINJAM
    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);

        return view('page.frontend.katalogbuku.pinjam', compact('buku'));
    }


    // SIMPAN PEMINJAMAN
    public function store(Request $request)
    {

        // VALIDASI
        $request->validate([
            'buku_id'     => 'required',
            'nama'        => 'required',
            'jumlah'      => 'required|integer|min:1',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam'
        ], [
            'tgl_kembali.after' => 'Tanggal kembali harus setelah tanggal pinjam.'
        ]);

        // CARI BUKU
        $buku = Buku::findOrFail($request->buku_id);

        // CEK STOK
        if ($request->jumlah > $buku->stok) {

            return redirect()->back()
            ->with('error','Jumlah buku melebihi stok yang tersedia');
        }

        // SIMPAN PEMINJAMAN
        Peminjaman::create([
            'buku_id'       => $request->buku_id,
            'anggota_id'    => session('anggota_id'),
            'nama_anggota'  => $request->nama,
            'jumlah'        => $request->jumlah,
            'tgl_pinjam'    => $request->tgl_pinjam,
            'tgl_kembali'   => $request->tgl_kembali,
            'status'        => 'menunggu'
        ]);

        // KURANGI STOK SESUAI JUMLAH
        $buku->stok = $buku->stok - $request->jumlah;

        // UPDATE STATUS BUKU
        if($buku->stok <= 0){
            $buku->status = 'Habis';
        }else{
            $buku->status = 'Tersedia';
        }

        $buku->save();

        // NOTIFIKASI
        return redirect()->back()->with('success','Peminjaman berhasil diajukan');
    }

}