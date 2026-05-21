<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
{
    $data = [
    ["nama"=>"Qeysha Nadin","email"=>"nadin@gmail.com","nim"=>"2210001","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar","foto"=>"https://ui-avatars.com/api/?name=Qeysha+Nadin&background=192853&color=fbbf24&size=80&rounded=true&bold=true"],
    ["nama"=>"Yohana Abigail","email"=>"hana@gmail.com","nim"=>"2210002","event"=>"Workshop UI/UX Design","kategori"=>"Workshop","foto"=>"https://ui-avatars.com/api/?name=Yohana+Abigail&background=7c3aed&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Naya Khairunnisa","email"=>"nisa@gmail.com","nim"=>"2210003","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar","foto"=>"https://ui-avatars.com/api/?name=Naya+Khairunnisa&background=059669&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Raka Pratama","email"=>"raka@gmail.com","nim"=>"2210004","event"=>"Pameran Teknologi","kategori"=>"Pameran","foto"=>"https://ui-avatars.com/api/?name=Raka+Pratama&background=dc2626&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Dimas Saputra","email"=>"dimas@gmail.com","nim"=>"2210005","event"=>"Talkshow Startup","kategori"=>"Talkshow","foto"=>"https://ui-avatars.com/api/?name=Dimas+Saputra&background=2563eb&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Siti Aisyah","email"=>"aisyah@gmail.com","nim"=>"2210006","event"=>"Pelatihan Public Speaking","kategori"=>"Pelatihan","foto"=>"https://ui-avatars.com/api/?name=Siti+Aisyah&background=d97706&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Andi Wijaya","email"=>"andi@gmail.com","nim"=>"2210007","event"=>"Workshop Web Development","kategori"=>"Workshop","foto"=>"https://ui-avatars.com/api/?name=Andi+Wijaya&background=0891b2&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Putri Maharani","email"=>"putri@gmail.com","nim"=>"2210008","event"=>"Seminar Digital Marketing","kategori"=>"Seminar","foto"=>"https://ui-avatars.com/api/?name=Putri+Maharani&background=be185d&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Fajar Nugroho","email"=>"fajar@gmail.com","nim"=>"2210009","event"=>"Pameran Teknologi","kategori"=>"Pameran","foto"=>"https://ui-avatars.com/api/?name=Fajar+Nugroho&background=4338ca&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Larasati Dewi","email"=>"laras@gmail.com","nim"=>"2210010","event"=>"Workshop Mobile App","kategori"=>"Workshop","foto"=>"https://ui-avatars.com/api/?name=Larasati+Dewi&background=0d9488&color=fff&size=80&rounded=true&bold=true"],

    ["nama"=>"Rizky Prakoso","email"=>"rizky@gmail.com","nim"=>"2210011","event"=>"Seminar Kewirausahaan","kategori"=>"Seminar","foto"=>"https://ui-avatars.com/api/?name=Rizky+Prakoso&background=9333ea&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Anisa Putri","email"=>"anisa@gmail.com","nim"=>"2210012","event"=>"Workshop UI/UX Design","kategori"=>"Workshop","foto"=>"https://ui-avatars.com/api/?name=Anisa+Putri&background=e11d48&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Bagas Saputra","email"=>"bagas@gmail.com","nim"=>"2210013","event"=>"Pameran Teknologi","kategori"=>"Pameran","foto"=>"https://ui-avatars.com/api/?name=Bagas+Saputra&background=1d4ed8&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Citra Lestari","email"=>"citra@gmail.com","nim"=>"2210014","event"=>"Talkshow Startup","kategori"=>"Talkshow","foto"=>"https://ui-avatars.com/api/?name=Citra+Lestari&background=15803d&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Dewi Anggraini","email"=>"dewi@gmail.com","nim"=>"2210015","event"=>"Pelatihan Public Speaking","kategori"=>"Pelatihan","foto"=>"https://ui-avatars.com/api/?name=Dewi+Anggraini&background=b45309&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Eko Prasetyo","email"=>"eko@gmail.com","nim"=>"2210016","event"=>"Workshop Web Development","kategori"=>"Workshop","foto"=>"https://ui-avatars.com/api/?name=Eko+Prasetyo&background=192853&color=fbbf24&size=80&rounded=true&bold=true"],
    ["nama"=>"Fina Salsabila","email"=>"fina@gmail.com","nim"=>"2210017","event"=>"Seminar Digital Marketing","kategori"=>"Seminar","foto"=>"https://ui-avatars.com/api/?name=Fina+Salsabila&background=7e22ce&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Galih Nugraha","email"=>"galih@gmail.com","nim"=>"2210018","event"=>"Pameran Teknologi","kategori"=>"Pameran","foto"=>"https://ui-avatars.com/api/?name=Galih+Nugraha&background=0369a1&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Hana Safitri","email"=>"hana.s@gmail.com","nim"=>"2210019","event"=>"Workshop Mobile App","kategori"=>"Workshop","foto"=>"https://ui-avatars.com/api/?name=Hana+Safitri&background=c2410c&color=fff&size=80&rounded=true&bold=true"],
    ["nama"=>"Iqbal Ramadhan","email"=>"iqbal@gmail.com","nim"=>"2210020","event"=>"Talkshow Startup","kategori"=>"Talkshow","foto"=>"https://ui-avatars.com/api/?name=Iqbal+Ramadhan&background=047857&color=fff&size=80&rounded=true&bold=true"],
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