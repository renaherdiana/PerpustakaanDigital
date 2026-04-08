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
    // TAMPIL DATA PETUGAS
    // ================================
    public function index()
    {
        $users = User::where('role','petugas')->latest()->get();

        return view('page.backend.superadmin.datauser.index', compact('users'));
    }


    // ================================
    // FORM TAMBAH PETUGAS
    // ================================
    public function create()
    {
        return view('page.backend.superadmin.datauser.create');
    }


    // ================================
    // SIMPAN PETUGAS
    // ================================
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|min:6',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);


        //UPLOAD PHOTO
        $photo = null;

        if($request->hasFile('photo')){
            $photo = $request->file('photo')->store('foto_user','public');
        }


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
            'status' => 'aktif',
            'photo' => $photo
        ]);


        return redirect()->route('superadmin.datauser.index')
        ->with('success','Petugas berhasil ditambahkan');
    }


    // ================================
    // DETAIL PETUGAS
    // ================================
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('page.backend.superadmin.datauser.show', compact('user'));
    }


    // ================================
    // FORM EDIT
    // ================================
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('page.backend.superadmin.datauser.edit', compact('user'));
    }


    // ================================
    // UPDATE PETUGAS
    // ================================
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);


        //UPLOAD PHOTO BARU
        if($request->hasFile('photo')){

            if($user->photo){
                Storage::disk('public')->delete($user->photo);
            }

            $photo = $request->file('photo')->store('foto_user','public');

            $user->photo = $photo;
        }


        //UPDATE PASSWORD JIKA DIISI
        if($request->password){
            $user->password = Hash::make($request->password);
        }


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status
        ]);


        return redirect()->route('superadmin.datauser.index')
        ->with('success','Data petugas berhasil diupdate');
    }


    // ================================
    // HAPUS PETUGAS
    // ================================
    public function destroy($id)
    {

        $user = User::findOrFail($id);


        //HAPUS PHOTO
        if($user->photo){
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();


        return redirect()->route('superadmin.datauser.index')
        ->with('success','Petugas berhasil dihapus');
    }

}