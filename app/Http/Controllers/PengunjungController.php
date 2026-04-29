<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
{
    $data = [
    ["nama"=>"Qeysha Nadin","email"=>"nadin@gmail.com","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar"],
    ["nama"=>"Yohana Abigail","email"=>"hana@gmail.com","event"=>"Workshop UI/UX Design","kategori"=>"Workshop"],
    ["nama"=>"Naya Khairunnisa","email"=>"nisa@gmail.com","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar"],
    ["nama"=>"Raka Pratama","email"=>"raka@gmail.com","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Dimas Saputra","email"=>"dimas@gmail.com","event"=>"Talkshow Startup","kategori"=>"Talkshow"],
    ["nama"=>"Siti Aisyah","email"=>"aisyah@gmail.com","event"=>"Pelatihan Public Speaking","kategori"=>"Pelatihan"],
    ["nama"=>"Andi Wijaya","email"=>"andi@gmail.com","event"=>"Workshop Web Development","kategori"=>"Workshop"],
    ["nama"=>"Putri Maharani","email"=>"putri@gmail.com","event"=>"Seminar Digital Marketing","kategori"=>"Seminar"],
    ["nama"=>"Fajar Nugroho","email"=>"fajar@gmail.com","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Larasati Dewi","email"=>"laras@gmail.com","event"=>"Workshop Mobile App","kategori"=>"Workshop"],

    ["nama"=>"Rizky Prakoso","email"=>"rizky@gmail.com","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar"],
    ["nama"=>"Anisa Putri","email"=>"anisa@gmail.com","event"=>"Workshop UI/UX Design","kategori"=>"Workshop"],
    ["nama"=>"Bagas Saputra","email"=>"bagas@gmail.com","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Citra Lestari","email"=>"citra@gmail.com","event"=>"Talkshow Startup","kategori"=>"Talkshow"],
    ["nama"=>"Dewi Anggraini","email"=>"dewi@gmail.com","event"=>"Pelatihan Public Speaking","kategori"=>"Pelatihan"],
    ["nama"=>"Eko Prasetyo","email"=>"eko@gmail.com","event"=>"Workshop Web Development","kategori"=>"Workshop"],
    ["nama"=>"Fina Salsabila","email"=>"fina@gmail.com","event"=>"Seminar Digital Marketing","kategori"=>"Seminar"],
    ["nama"=>"Galih Nugraha","email"=>"galih@gmail.com","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Hana Safitri","email"=>"hana.s@gmail.com","event"=>"Workshop Mobile App","kategori"=>"Workshop"],
    ["nama"=>"Iqbal Ramadhan","email"=>"iqbal@gmail.com","event"=>"Talkshow Startup","kategori"=>"Talkshow"],
];

    return view('pages.admin.pengunjung', compact('data'));
}    public function create()
    {
        return view('pengunjung_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
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