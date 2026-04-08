<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{

    public function index()
    {

        // UPDATE STATUS TERLAMBAT OTOMATIS
        Peminjaman::where('status','dipinjam')
        ->whereDate('tgl_kembali','<', Carbon::today())
        ->update([
            'status' => 'terlambat'
        ]);

        // AMBIL DATA PEMINJAMAN + RELASI BUKU
        $peminjamans = Peminjaman::with('buku')
                        ->latest()
                        ->paginate(10);

        return view(
            'page.backend.admin.peminjaman.index',
            compact('peminjamans')
        );
    }



    public function show($id)
    {

        // DETAIL PEMINJAMAN
       $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        return view(
            'page.backend.admin.peminjaman.show',
            compact('peminjaman')
        );
    }



    public function update(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|in:dipinjam,ditolak,selesai'
        ]);

        $pinjam = Peminjaman::findOrFail($id);

        // UPDATE STATUS
        $pinjam->status = $request->status;
        $pinjam->save();

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success','Status peminjaman berhasil diperbarui');
    }

}