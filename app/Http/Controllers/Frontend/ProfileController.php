<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $anggota = Anggota::findOrFail(session('anggota_id'));
        return view('page.frontend.profile.index', compact('anggota'));
    }

    public function edit()
    {
        $anggota = Anggota::findOrFail(session('anggota_id'));
        return view('page.frontend.profile.edit', compact('anggota'));
    }

    public function update(Request $request)
    {
        $anggota = Anggota::findOrFail(session('anggota_id'));

        $request->validate([
            'email'    => 'required|email|unique:anggotas,email,' . $anggota->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $anggota->email = $request->email;

        if ($request->filled('password')) {
            $anggota->password = Hash::make($request->password);
        }

        $anggota->save();

        // update session nama jika berubah
        session(['anggota_nama' => $anggota->nama]);

        return redirect()->route('anggota.profile')->with('success', 'Profile berhasil diperbarui');
    }
}
