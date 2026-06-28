<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $nama_kategori = trim($request->nama);

        // Check if category name already exists (case-insensitive)
        $exists = Kategori::where('nama_kategori', $nama_kategori)
            ->when($request->id, function ($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kategori "' . $nama_kategori . '" sudah ada sebelumnya!');
        }

        if ($request->id) {
            $kategori = Kategori::find($request->id);
            if ($kategori) {
                $kategori->update([
                    'nama_kategori' => $nama_kategori
                ]);
                return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui.');
            }
        } else {
            Kategori::create([
                'nama_kategori' => $nama_kategori
            ]);
            return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan.');
        }

        return redirect()->route('admin.kategori');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            // Check if there are any events associated with this category
            if ($kategori->events()->exists()) {
                return redirect()->route('admin.kategori')->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih memiliki event di dalamnya!');
            }
            
            $kategori->delete();
            return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->route('admin.kategori')->with('error', 'Kategori tidak ditemukan.');
    }
}
