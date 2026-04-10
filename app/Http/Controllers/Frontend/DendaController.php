<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{

    /* ===============================
    HALAMAN LIST DENDA USER
    =============================== */

    public function index()
    {

        // AMBIL DATA DENDA milik anggota login
        $dendas = Denda::with(['peminjaman.buku'])
                    ->whereHas('peminjaman', function($q){
                        $q->where('anggota_id', session('anggota_id'));
                    })
                    ->latest()
                    ->paginate(5);

        // TOTAL DENDA BELUM LUNAS milik anggota login
        $totalDenda = Denda::where('status','!=','selesai')
                        ->whereHas('peminjaman', function($q){
                            $q->where('anggota_id', session('anggota_id'));
                        })
                        ->get()
                        ->sum(function($item){
                            return $item->hari_terlambat * 1000;
                        });


        return view('page.frontend.denda.index', compact('dendas','totalDenda'));

    }



    /* ===============================
    DETAIL DENDA
    =============================== */

    public function detail($id)
    {

        // AMBIL DETAIL DENDA
        $denda = Denda::with('peminjaman.buku')->findOrFail($id);

        return view('page.frontend.denda.show', compact('denda'));

    }

}