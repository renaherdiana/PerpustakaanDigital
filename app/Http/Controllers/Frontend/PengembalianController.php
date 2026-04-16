<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'peminjaman_id' => 'required'
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        // cek denda belum lunas
        $dendaBelumLunas = $peminjaman->denda()->where('status','menunggu')->exists();
        if($dendaBelumLunas){
            return redirect()->back()->with('error','Kamu masih memiliki denda yang belum dibayar. Lunasi denda terlebih dahulu sebelum mengajukan pengembalian.');
        }

        // cek sudah pernah ajukan (bukan ditolak_pengembalian)
        $cek = Pengembalian::where('peminjaman_id',$peminjaman->id)->first();
        if($cek && $peminjaman->status !== 'ditolak_pengembalian'){
            return redirect()->back()->with('error','Pengembalian sudah diajukan');
        }

        // simpan pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_dikembalikan' => Carbon::now(),
            'status' => 'menunggu_verifikasi'
        ]);

        // update status peminjaman
        $peminjaman->status = 'menunggu_verifikasi';
        $peminjaman->save();

        return redirect()->back()->with('success','Pengajuan pengembalian berhasil dikirim');

    }

}