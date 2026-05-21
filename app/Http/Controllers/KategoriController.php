<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return view('pages.admin.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        if ($request->id) {
            $kategori = Kategori::find($request->id);
            if ($kategori) {
                $kategori->update([
                    'nama_kategori' => $request->nama
                ]);
            }
        } else {
            Kategori::create([
                'nama_kategori' => $request->nama
            ]);
        }

        return redirect()->route('admin.kategori');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
        }

        return redirect()->route('admin.kategori');
    }
}
