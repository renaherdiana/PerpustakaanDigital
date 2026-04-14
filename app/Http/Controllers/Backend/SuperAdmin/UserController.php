<?php

namespace App\Http\Controllers\Backend\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ================================
    // TAMPIL DATA PETUGAS (index)
    // ================================
    public function index(Request $request)
    {
        $query = User::where('role','petugas');

        // Filter status
        if ($request->status && in_array($request->status, ['aktif','tidak aktif'])) {
            $query->where('status', $request->status);
        }

        // Pencarian nama
        if ($request->search) {
            $query->where('name','like',"%{$request->search}%");
        }

        // Pagination 10 per halaman
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('page.backend.superadmin.datauser.index', compact('users'));
    }

    // ================================
    // FORM TAMBAH PETUGAS (create)
    // ================================
    public function create()
    {
        return view('page.backend.superadmin.datauser.create');
    }

    // ================================
    // SIMPAN PETUGAS (store)
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required',
            'password' => 'required|min:6',
            'status'   => 'required|in:aktif,tidak_aktif',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('foto_user','public');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
            'status'   => $request->status,
            'photo'    => $photo
        ]);

        return redirect()->route('superadmin.datauser.index')
                         ->with('success','Petugas berhasil ditambahkan');
    }

    // ================================
    // DETAIL PETUGAS (show)
    // ================================
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('page.backend.superadmin.datauser.show', compact('user'));
    }

    // ================================
    // FORM EDIT PETUGAS (edit)
    // ================================
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('page.backend.superadmin.datauser.edit', compact('user'));
    }

    // ================================
    // UPDATE PETUGAS (update)
    // ================================
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload photo baru jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('foto_user','public');
        }

        // Update password jika diisi
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Update data lain
        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'status' => $request->status
        ]);

        return redirect()->route('superadmin.datauser.index')
                         ->with('success','Data petugas berhasil diupdate');
    }

    // ================================
    // HAPUS PETUGAS (destroy)
    // ================================
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('superadmin.datauser.index')
                         ->with('success','Petugas berhasil dihapus');
    }
}