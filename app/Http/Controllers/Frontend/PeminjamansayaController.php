<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamansayaController extends Controller
{

    /* =========================================
       HALAMAN PEMINJAMAN SAYA
    ========================================= */

    public function index(Request $request)
    {

        // UPDATE STATUS TERLAMBAT OTOMATIS
        Peminjaman::where('status','dipinjam')
        ->whereDate('tgl_kembali','<', Carbon::today())
        ->update([
            'status' => 'terlambat'
        ]);


        // QUERY PEMINJAMAN + RELASI BUKU
        $query = Peminjaman::with('buku');


        /* ===============================
           SEARCH JUDUL BUKU
        =============================== */

        if($request->search){

            $query->whereHas('buku', function($q) use ($request){

                $q->where('judul','like','%'.$request->search.'%');

            });

        }


        /* ===============================
           FILTER STATUS
        =============================== */

        if($request->status){

            $query->where('status',$request->status);

        }


        /* ===============================
           AMBIL DATA
        =============================== */

        $peminjamans = $query
                        ->orderBy('created_at','desc')
                        ->paginate(5)
                        ->withQueryString();


        return view(
            'page.frontend.peminjamansaya.index',
            compact('peminjamans')
        );

    }



    /* =========================================
       DETAIL PEMINJAMAN
    ========================================= */

    public function show($id)
    {

        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        return view(
            'page.frontend.peminjamansaya.show',
            compact('peminjaman')
        );

    }

    // Contoh di Controller
    public function ajukanPengembalian(Request $request){
        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        $peminjaman->status = 'menunggu_verifikasi';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Buku berhasil diajukan untuk pengembalian!');
    }

}