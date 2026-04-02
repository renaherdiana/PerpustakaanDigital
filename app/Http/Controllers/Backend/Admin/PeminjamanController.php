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
        ->whereDate('tgl_kembali','<', Carbon::now())
        ->update([
            'status' => 'terlambat'
        ]);

        // ambil data peminjaman + pagination
        $peminjamans = Peminjaman::latest()->paginate(10);

        return view('page.backend.admin.peminjaman.index', compact('peminjamans'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        return view('page.backend.admin.peminjaman.show', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // update status
        $pinjam->status = $request->status;
        $pinjam->save();

        return redirect()->back()->with('success','Status peminjaman berhasil diperbarui');
    }

}