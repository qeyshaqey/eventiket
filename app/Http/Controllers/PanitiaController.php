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
        ];

        $pengajuan = [
            ["nama" => "Gilang", "email" => "gilang@gmail.com", "tanggal" => "08 Apr 2026", "ukm" => "HMTI"],
            ["nama" => "Jelita", "email" => "jelita@gmail.com", "tanggal" => "09 Apr 2026", "ukm" => "UKM Seni"],
        ];

        $events = [];

        return view('panitia', compact('kelola', 'pengajuan', 'events'));
    }
}
