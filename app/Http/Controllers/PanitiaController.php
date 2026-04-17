<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanitiaController extends Controller
{
    public function index()
    {
        $kelola = [
            ["nama" => "Inessa Putri", "email" => "inessa@gmail.com", "nim" => "2210112345", "ukm" => "HMTI", "status" => "Aktif"],
            ["nama" => "Fariz Ramadhan", "email" => "fariz@gmail.com", "nim" => "2210112346", "ukm" => "HMTI", "status" => "Aktif"],
            ["nama" => "Puji Davi", "email" => "puji@gmail.com", "nim" => "2210112347", "ukm" => "HMTI", "status" => "Nonaktif"],
            ["nama" => "Dimas Saputra", "email" => "dimas@gmail.com", "nim" => "2210112348", "ukm" => "BEM", "status" => "Aktif"],
            ["nama" => "Siti Aisyah", "email" => "aisyah@gmail.com", "nim" => "2210112349", "ukm" => "UKM Seni", "status" => "Aktif"],
            ["nama" => "Andi Wijaya", "email" => "andi@gmail.com", "nim" => "2210112350", "ukm" => "HMTI", "status" => "Nonaktif"],
            ["nama" => "Putri Maharani", "email" => "putri@gmail.com", "nim" => "2210112351", "ukm" => "UKM Olahraga", "status" => "Aktif"],
            ["nama" => "Fajar Nugroho", "email" => "fajar@gmail.com", "nim" => "2210112352", "ukm" => "BEM", "status" => "Aktif"],
            ["nama" => "Larasati Dewi", "email" => "laras@gmail.com", "nim" => "2210112353", "ukm" => "UKM Seni", "status" => "Nonaktif"],
            ["nama" => "Rizky Prakoso", "email" => "rizky@gmail.com", "nim" => "2210112354", "ukm" => "HMTI", "status" => "Aktif"],
        ];

        $pengajuan = [
            ["nama" => "Gilang", "email" => "gilang@gmail.com", "nim" => "2210112347", "tanggal" => "08 Apr 2026", "ukm" => "HMTI"],
            ["nama" => "Jelita", "email" => "jelita@gmail.com", "nim" => "2210112348", "tanggal" => "09 Apr 2026", "ukm" => "UKM Seni"],
            ["nama" => "Raka Pratama", "email" => "raka@gmail.com", "nim" => "2210112349", "tanggal" => "10 Apr 2026", "ukm" => "BEM"],
            ["nama" => "Siti Aisyah", "email" => "aisyah@gmail.com", "nim" => "2210112350", "tanggal" => "11 Apr 2026", "ukm" => "UKM Olahraga"],
            ["nama" => "Andi Wijaya", "email" => "andi@gmail.com", "nim" => "2210112351", "tanggal" => "12 Apr 2026", "ukm" => "HMTI"],
            ["nama" => "Putri Maharani", "email" => "putri@gmail.com", "nim" => "2210112352", "tanggal" => "13 Apr 2026", "ukm" => "UKM Seni"],
            ["nama" => "Fajar Nugroho", "email" => "fajar@gmail.com", "nim" => "2210112353", "tanggal" => "14 Apr 2026", "ukm" => "BEM"],
            ["nama" => "Larasati Dewi", "email" => "laras@gmail.com", "nim" => "2210112354", "tanggal" => "15 Apr 2026", "ukm" => "UKM Olahraga"],
            ["nama" => "Rizky Prakoso", "email" => "rizky@gmail.com", "nim" => "2210112355", "tanggal" => "16 Apr 2026", "ukm" => "HMTI"],
            ["nama" => "Anisa Putri", "email" => "anisa@gmail.com", "nim" => "2210112356", "tanggal" => "17 Apr 2026", "ukm" => "UKM Seni"],
        ];

        $events = [];

        return view('panitia', compact('kelola', 'pengajuan', 'events'));
    }
}
