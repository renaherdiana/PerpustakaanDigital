<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Storage;

class DataBukuController extends Controller
{

    public function index(Request $request)
    {
        $query = Buku::latest();

        if ($request->search) {
            $query->where('judul', 'like', '%'.$request->search.'%');
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $bukus = $query->paginate(5)->withQueryString();
        $kategoris = Buku::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('page.backend.admin.databuku.index', compact('bukus', 'kategoris'));
    }


    public function create()
    {
        return view('page.backend.admin.databuku.create');
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255|unique:bukus,judul',
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
            'judul' => 'required|string|max:255|unique:bukus,judul,' . $id,
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

        $sedangDipinjam = $buku->peminjamans()->where('status', 'dipinjam')->exists();

        if ($sedangDipinjam) {
            return redirect()
                    ->route('admin.databuku.index')
                    ->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam.');
        }

        $adaPengembalianBelumVerifikasi = Pengembalian::whereHas('peminjaman', function($q) use ($id) {
            $q->where('buku_id', $id)->where('status', 'menunggu_verifikasi');
        })->exists();

        if ($adaPengembalianBelumVerifikasi) {
            return redirect()
                    ->route('admin.databuku.index')
                    ->with('error', 'Buku tidak dapat dihapus karena ada pengembalian yang belum diverifikasi.');
        }

        if($buku->photo){
            Storage::disk('public')->delete($buku->photo);
        }

        $buku->delete();

        return redirect()
                ->route('admin.databuku.index')
                ->with('success','Buku berhasil dihapus');
    }

}