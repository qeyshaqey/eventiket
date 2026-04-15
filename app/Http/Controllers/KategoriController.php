<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = session('kategori', [
            ['id' => 1, 'nama_kategori' => 'Musik'],
            ['id' => 2, 'nama_kategori' => 'Sosial'],
        ]);

        return view('kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = session('kategori', []);

        if ($request->id) {
            foreach ($data as &$item) {
                if ($item['id'] == $request->id) {
                    $item['nama_kategori'] = $request->nama;
                }
            }
        } else {
            $data[] = [
                'id' => count($data) + 1,
                'nama_kategori' => $request->nama
            ];
        }

        session(['kategori' => $data]);

        return redirect()->route('kategori');
    }

    public function destroy($id)
    {
        $data = session('kategori', []);

        $data = array_filter($data, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        session(['kategori' => array_values($data)]);

        return redirect()->route('kategori');
    }
}