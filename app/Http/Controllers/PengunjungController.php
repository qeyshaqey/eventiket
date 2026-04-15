<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
    {
        $data = [
            ["nama"=>"Qeysha Nadin","email"=>"nadin@gmail.com","nim"=>"1122334455","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar"],
            ["nama"=>"Yohana Abigail","email"=>"hana@gmail.com","nim"=>"2233445566","event"=>"Workshop UI/UX Design","kategori"=>"Workshop"],
            ["nama"=>"Naya Khairunnisa","email"=>"nisa@gmail.com","nim"=>"3344556677","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar"],
            ["nama"=>"Raka Pratama","email"=>"raka@gmail.com","nim"=>"4455667788","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
        ];

        return view('pengunjung', compact('data'));
    }

    public function create()
    {
        return view('pengunjung_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'nim' => 'required',
            'event' => 'required',
            'kategori' => 'required',
        ]);

        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        return "Detail pengunjung ID: " . $id;
    }

    public function edit($id)
    {
        return "Edit pengunjung ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil dihapus');
    }
}