<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /* ===============================
    TAMPILKAN DATA PENGEMBALIAN
    =============================== */
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.buku')->latest()->paginate(10); 

        return view(
            'page.backend.admin.pengembalian.index',
            compact('pengembalian')
        );
    }

    /* ===============================
    AJUKAN PENGEMBALIAN (DARI ANGGOTA)
    =============================== */
    public function ajukanPengembalian(Request $request)
    {
        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        // update status peminjaman menjadi menunggu_verifikasi
        $peminjaman->update([
            'status' => 'menunggu_verifikasi'
        ]);

        // buat record pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_pengembalian' => Carbon::now()
        ]);

        return redirect()->back()->with('success','Pengembalian berhasil diajukan. Menunggu verifikasi admin.');
    }

    /* ===============================
    VERIFIKASI PENGEMBALIAN + BUAT DENDA
    =============================== */
    public function verifikasi($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // update status pengembalian
        $pengembalian->update([
            'status' => 'dikembalikan'
        ]);

        // ambil data peminjaman
        $peminjaman = $pengembalian->peminjaman;

        // update status peminjaman menjadi selesai
        $peminjaman->update([
            'status' => 'selesai'
        ]);

        // tambah stok buku
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok', $peminjaman->jumlah);
            $buku->status = $buku->stok > 0 ? 'Tersedia' : 'Habis';
            $buku->save();
        }

        /* ===============================
        HITUNG DAN SIMPAN DENDA (JIKA TERLAMBAT)
        =============================== */
        $tglKembali = Carbon::parse($peminjaman->tgl_kembali)->startOfDay();
        $tglHariIni = Carbon::now()->startOfDay();

        if ($tglHariIni->gt($tglKembali)) {
            $hariTerlambat = $tglKembali->diffInDays($tglHariIni);
            $totalDenda = $hariTerlambat * $peminjaman->jumlah * 1000;

            // buat record denda jika belum ada
            Denda::updateOrCreate(
                ['peminjaman_id' => $peminjaman->id],
                [
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $totalDenda,
                    'status' => 'menunggu'
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success','Pengembalian berhasil diverifikasi');
    }

    /* ===============================
    TOLAK PENGEMBALIAN
    =============================== */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string',
            'denda_kerusakan' => 'nullable|integer|min:0',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $peminjaman = $pengembalian->peminjaman;

        // Hapus record pengembalian
        $pengembalian->delete();

        // Update status peminjaman + simpan alasan
        $peminjaman->update([
            'status' => 'ditolak_pengembalian',
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        // Kalau ada denda kerusakan, simpan ke tabel dendas
        if ($request->filled('denda_kerusakan') && $request->denda_kerusakan > 0) {
            Denda::updateOrCreate(
                ['peminjaman_id' => $peminjaman->id, 'jenis' => 'kerusakan'],
                [
                    'hari_terlambat' => 0,
                    'denda' => $request->denda_kerusakan,
                    'status' => 'menunggu',
                ]
            );
        }

        return redirect()->back()->with('success', 'Pengembalian ditolak.');
    }

    /* ===============================
    DETAIL PENGEMBALIAN
    =============================== */
    public function show($id)
    {
        $pengembalian = Pengembalian::with(
            'peminjaman.buku'
        )->findOrFail($id);

        /* ===============================
        HITUNG DENDA (HANYA UNTUK TAMPILAN)
        =============================== */
        $tglKembali = Carbon::parse($pengembalian->peminjaman->tgl_kembali)->startOfDay();
        $tglDikembalikan = Carbon::parse($pengembalian->created_at)->startOfDay();

        $denda = 0;
        if ($tglDikembalikan->gt($tglKembali)) {
            $hariTerlambat = $tglKembali->diffInDays($tglDikembalikan);
            $denda = $hariTerlambat * 1000;
        }

        return view(
            'page.backend.admin.pengembalian.show',
            compact('pengembalian','denda')
        );
    }
}