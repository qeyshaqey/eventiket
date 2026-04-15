<?php

namespace App\Http\Controllers;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $total_pengunjung = 1248;
        $pengunjung_growth = 38;
        $total_panitia = 20;
        $total_event = 15;

        $events = [
            ["tanggal"=>"12 Apr","nama"=>"Workshop UI/UX Design","kategori"=>"Workshop","waktu"=>"09:00 - 12:00","lokasi"=>"Aula Kampus","deskripsi"=>"Pelatihan desain UI/UX untuk mahasiswa tingkat akhir."],
            ["tanggal"=>"06 Jun","nama"=>"Seminar Kewirausahaan","kategori"=>"Seminar","waktu"=>"13:00 - 15:00","lokasi"=>"Ruang Seminar","deskripsi"=>"Belajar membangun bisnis dari nol bersama praktisi."],
            ["tanggal"=>"30 Jul","nama"=>"Festival Budaya Kampus","kategori"=>"Festival","waktu"=>"08:00","lokasi"=>"Lapangan","deskripsi"=>"Acara tahunan perayaan budaya nusantara."],
            ["tanggal"=>"01 Aug","nama"=>"Music Concert","kategori"=>"Konser","waktu"=>"19:00","lokasi"=>"Hall A","deskripsi"=>"Konser musik mahasiswa dan tamu undangan spesial."],
            ["tanggal"=>"05 Aug","nama"=>"Tech Talk AI","kategori"=>"Seminar","waktu"=>"10:00","lokasi"=>"Lab 1","deskripsi"=>"Diskusi perkembangan kecerdasan buatan masa kini."],
            ["tanggal"=>"10 Aug","nama"=>"Lomba Coding","kategori"=>"Kompetisi","waktu"=>"08:00","lokasi"=>"Lab Komputer","deskripsi"=>"Hackathon 24 jam untuk mahasiswa teknik informatika."],
            ["tanggal"=>"15 Aug","nama"=>"Pameran Seni","kategori"=>"Pameran","waktu"=>"09:00","lokasi"=>"Galeri","deskripsi"=>"Pameran karya seni rupa mahasiswa semester akhir."],
            ["tanggal"=>"20 Aug","nama"=>"Startup Pitch","kategori"=>"Bisnis","waktu"=>"14:00","lokasi"=>"Aula","deskripsi"=>"Presentasi ide startup kepada investor dan mentor."],
            ["tanggal"=>"25 Aug","nama"=>"Workshop Fotografi","kategori"=>"Workshop","waktu"=>"10:00","lokasi"=>"Studio","deskripsi"=>"Belajar teknik dasar fotografi dan editing foto."],
        ];

        return view('dashboard-admin', compact(
            'total_pengunjung',
            'pengunjung_growth',
            'total_panitia',
            'total_event',
            'events'
        ));
    }
}