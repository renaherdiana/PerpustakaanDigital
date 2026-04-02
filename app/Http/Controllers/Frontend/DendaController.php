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

        // AMBIL DATA DENDA + RELASI BUKU
        $dendas = Denda::with(['peminjaman.buku'])
                    ->latest()
                    ->paginate(5);


        // TOTAL DENDA YANG BELUM LUNAS
        $totalDenda = Denda::where('status','!=','selesai')
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