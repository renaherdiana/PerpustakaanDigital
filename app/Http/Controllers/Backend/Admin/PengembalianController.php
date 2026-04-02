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
        $pengembalian = Pengembalian::with(
            'peminjaman.buku'
        )->latest()->get();

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
            $buku->increment('stok');
        }

        /* ===============================
        HITUNG DAN SIMPAN DENDA (JIKA TERLAMBAT)
        =============================== */
        $tglKembali = Carbon::parse($peminjaman->tgl_kembali);
        $tglDikembalikan = Carbon::parse($pengembalian->created_at);

        if ($tglDikembalikan->gt($tglKembali)) {
            $hariTerlambat = $tglKembali->diffInDays($tglDikembalikan);
            $totalDenda = $hariTerlambat * 1000;

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
        $tglKembali = Carbon::parse($pengembalian->peminjaman->tgl_kembali);
        $tglDikembalikan = Carbon::parse($pengembalian->created_at);

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