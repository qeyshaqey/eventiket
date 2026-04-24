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
    ["nama"=>"Dimas Saputra","email"=>"dimas@gmail.com","nim"=>"5566778899","event"=>"Talkshow Startup","kategori"=>"Talkshow"],
    ["nama"=>"Siti Aisyah","email"=>"aisyah@gmail.com","nim"=>"6677889900","event"=>"Pelatihan Public Speaking","kategori"=>"Pelatihan"],
    ["nama"=>"Andi Wijaya","email"=>"andi@gmail.com","nim"=>"7788990011","event"=>"Workshop Web Development","kategori"=>"Workshop"],
    ["nama"=>"Putri Maharani","email"=>"putri@gmail.com","nim"=>"8899001122","event"=>"Seminar Digital Marketing","kategori"=>"Seminar"],
    ["nama"=>"Fajar Nugroho","email"=>"fajar@gmail.com","nim"=>"9900112233","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Larasati Dewi","email"=>"laras@gmail.com","nim"=>"1011121314","event"=>"Workshop Mobile App","kategori"=>"Workshop"],

    ["nama"=>"Rizky Prakoso","email"=>"rizky@gmail.com","nim"=>"1213141516","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar"],
    ["nama"=>"Anisa Putri","email"=>"anisa@gmail.com","nim"=>"1314151617","event"=>"Workshop UI/UX Design","kategori"=>"Workshop"],
    ["nama"=>"Bagas Saputra","email"=>"bagas@gmail.com","nim"=>"1415161718","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Citra Lestari","email"=>"citra@gmail.com","nim"=>"1516171819","event"=>"Talkshow Startup","kategori"=>"Talkshow"],
    ["nama"=>"Dewi Anggraini","email"=>"dewi@gmail.com","nim"=>"1617181920","event"=>"Pelatihan Public Speaking","kategori"=>"Pelatihan"],
    ["nama"=>"Eko Prasetyo","email"=>"eko@gmail.com","nim"=>"1718192021","event"=>"Workshop Web Development","kategori"=>"Workshop"],
    ["nama"=>"Fina Salsabila","email"=>"fina@gmail.com","nim"=>"1819202122","event"=>"Seminar Digital Marketing","kategori"=>"Seminar"],
    ["nama"=>"Galih Nugraha","email"=>"galih@gmail.com","nim"=>"1920212223","event"=>"Pameran Teknologi","kategori"=>"Pameran"],
    ["nama"=>"Hana Safitri","email"=>"hana.s@gmail.com","nim"=>"2021222324","event"=>"Workshop Mobile App","kategori"=>"Workshop"],
    ["nama"=>"Iqbal Ramadhan","email"=>"iqbal@gmail.com","nim"=>"2122232425","event"=>"Talkshow Startup","kategori"=>"Talkshow"],
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