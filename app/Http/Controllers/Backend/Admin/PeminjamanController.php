<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{

    public function index(Request $request)
    {
        Peminjaman::where('status','dipinjam')
        ->whereDate('tgl_kembali','<', Carbon::today())
        ->update(['status' => 'terlambat']);

        $query = Peminjaman::with('buku')->latest();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_anggota', 'like', '%'.$request->search.'%')
                  ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', '%'.$request->search.'%'));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->paginate(10)->withQueryString();

        return view('page.backend.admin.peminjaman.index', compact('peminjamans'));
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