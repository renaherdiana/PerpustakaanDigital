<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataAnggotaController extends Controller
{
    // ===============================
    // TAMPIL DATA
    // ===============================
    public function index(Request $request)
    {
        $query = Anggota::orderBy('nama', 'asc');

        if ($request->search) {
            $query->where('nama', 'like', '%'.$request->search.'%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $anggota = $query->paginate(10)->withQueryString();

        return view('page.backend.admin.dataanggota.index', compact('anggota'));
    }

    // ===============================
    // FORM TAMBAH
    // ===============================
    public function create()
    {
        return view('page.backend.admin.dataanggota.create');
    }

    // ===============================
    // SIMPAN DATA
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:anggotas,nis',
            'kelas' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:anggotas,email'
        ]);

        Anggota::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'status' => $request->status,
            'email' => $request->email,
            'password' => Hash::make($request->nis) // password default dari NIS
        ]);

        return redirect()->route('admin.anggota.index')
                         ->with('success','Data anggota berhasil ditambahkan');
    }

    // ===============================
    // DETAIL
    // ===============================
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('page.backend.admin.dataanggota.show', compact('anggota'));
    }

    // ===============================
    // FORM EDIT
    // ===============================
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('page.backend.admin.dataanggota.edit', compact('anggota'));
    }

    // ===============================
    // UPDATE DATA
    // ===============================
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:anggotas,nis,'.$anggota->id,
            'kelas' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:anggotas,email,'.$anggota->id
        ]);

        $anggota->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'status' => $request->status,
            'email' => $request->email,
        ]);

        // Opsional: update password jika diisi
        if ($request->password) {
            $anggota->password = Hash::make($request->password);
            $anggota->save();
        }

        return redirect()->route('admin.anggota.index')
                         ->with('success','Data anggota berhasil diupdate');
    }

    // ===============================
    // HAPUS DATA
    // ===============================
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('admin.anggota.index')
                         ->with('success','Data anggota berhasil dihapus');
    }
}