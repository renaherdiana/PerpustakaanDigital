<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

class DataBukuController extends Controller
{

    public function index()
    {
        $bukus = Buku::latest()->get();

        return view('page.backend.admin.databuku.index', compact('bukus'));
    }


    public function create()
    {
        return view('page.backend.admin.databuku.create');
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0'
        ]);

        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store('buku','public');
        }

        $data['status'] = $data['stok'] > 0 ? 'Tersedia' : 'Habis';

        Buku::create($data);

        return redirect()
                ->route('admin.databuku.index')
                ->with('success','Buku berhasil ditambahkan');
    }



    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        return view('page.backend.admin.databuku.show', compact('buku'));
    }



    public function edit($id)
    {
        $buku = Buku::findOrFail($id);

        return view('page.backend.admin.databuku.edit', compact('buku'));
    }



    public function update(Request $request, $id)
    {

        $buku = Buku::findOrFail($id);

        $data = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0'
        ]);

        if($request->hasFile('photo')){

            if($buku->photo){
                Storage::disk('public')->delete($buku->photo);
            }

            $data['photo'] = $request->file('photo')->store('buku','public');
        }

        $data['status'] = $data['stok'] > 0 ? 'Tersedia' : 'Habis';

        $buku->update($data);

        return redirect()
                ->route('admin.databuku.index')
                ->with('success','Buku berhasil diupdate');
    }



    public function destroy($id)
    {

        $buku = Buku::findOrFail($id);

        if($buku->photo){
            Storage::disk('public')->delete($buku->photo);
        }

        $buku->delete();

        return redirect()
                ->route('admin.databuku.index')
                ->with('success','Buku berhasil dihapus');
    }

}