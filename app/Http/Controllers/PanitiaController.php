<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanitiaController extends Controller
{
    public function index()
    {
        // ================= KELOLA =================
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

        // ================= PENGAJUAN =================
        $pengajuan = [
            [
                "nama" => "Galang", 
                "email" => "galang@gmail.com", 
                "nim" => "2210112347", 
                "tanggal" => "08 Apr 2026", 
                "ukm" => "HMTI",
                "event_nama" => "HMTI Anniversary 2026",
                "kategori_event" => "Hiburan",
                "tgl_event" => "15 Mei 2026",
                "deskripsi" => "Perayaan ulang tahun HMTI yang ke-10 dengan berbagai lomba dan hiburan musik."
            ],
            [
                "nama" => "Jelita", 
                "email" => "jelita@gmail.com", 
                "nim" => "2210112348", 
                "tanggal" => "09 Apr 2026", 
                "ukm" => "UKM Seni",
                "event_nama" => "Art Exhibition: Soul of Polibatam",
                "kategori_event" => "Hiburan",
                "tgl_event" => "20 Juni 2026",
                "deskripsi" => "Pameran karya seni rupa dan pertunjukan teater mahasiswa Polibatam."
            ],
            [
                "nama" => "Raka Pratama", 
                "email" => "raka@gmail.com", 
                "nim" => "2210112349", 
                "tanggal" => "10 Apr 2026", 
                "ukm" => "BEM",
                "event_nama" => "National Seminar: Future Tech",
                "kategori_event" => "Seminar",
                "tgl_event" => "05 Juli 2026",
                "deskripsi" => "Seminar nasional menghadirkan pembicara dari industri teknologi terkemuka."
            ],
            [
                "nama" => "Siti Aisyah", 
                "email" => "aisyah@gmail.com", 
                "nim" => "2210112350", 
                "tanggal" => "11 Apr 2026", 
                "ukm" => "UKM Olahraga",
                "event_nama" => "Polibatam Cup 2026",
                "kategori_event" => "Olahraga",
                "tgl_event" => "12 Agustus 2026",
                "deskripsi" => "Turnamen futsal dan basket antar jurusan se-Polibatam."
            ],
            [
                "nama" => "Andi Wijaya", 
                "email" => "andi@gmail.com", 
                "nim" => "2210112351", 
                "tanggal" => "12 Apr 2026", 
                "ukm" => "HMTI",
                "event_nama" => "Web Dev Workshop",
                "kategori_event" => "Workshop",
                "tgl_event" => "10 September 2026",
                "deskripsi" => "Workshop intensif pembuatan website modern menggunakan Laravel."
            ],
            [
                "nama" => "Putri Maharani", 
                "email" => "putri@gmail.com", 
                "nim" => "2210112352", 
                "tanggal" => "13 Apr 2026", 
                "ukm" => "UKM Seni",
                "event_nama" => "Music Night",
                "kategori_event" => "Hiburan",
                "tgl_event" => "15 Oktober 2026",
                "deskripsi" => "Konser musik mahasiswa dengan bintang tamu lokal Batam."
            ],
            [
                "nama" => "Fajar Nugroho", 
                "email" => "fajar@gmail.com", 
                "nim" => "2210112353", 
                "tanggal" => "14 Apr 2026", 
                "ukm" => "BEM",
                "event_nama" => "Social Action 2026",
                "kategori_event" => "Lainnya",
                "tgl_event" => "20 November 2026",
                "deskripsi" => "Kegiatan pengabdian masyarakat di desa terpencil."
            ],
            [
                "nama" => "Larasati Dewi", 
                "email" => "laras@gmail.com", 
                "nim" => "2210112354", 
                "tanggal" => "15 Apr 2026", 
                "ukm" => "UKM Olahraga",
                "event_nama" => "E-Sport Tournament",
                "kategori_event" => "Kompetisi",
                "tgl_event" => "05 Desember 2026",
                "deskripsi" => "Turnamen Mobile Legends dan Valorant tingkat Politeknik."
            ],
            [
                "nama" => "Rizky Prakoso", 
                "email" => "rizky@gmail.com", 
                "nim" => "2210112355", 
                "tanggal" => "16 Apr 2026", 
                "ukm" => "HMTI",
                "event_nama" => "Cyber Security Seminar",
                "kategori_event" => "Seminar",
                "tgl_event" => "10 Januari 2027",
                "deskripsi" => "Seminar tentang keamanan data di era digital."
            ],
            [
                "nama" => "Anisa Putri", 
                "email" => "anisa@gmail.com", 
                "nim" => "2210112356", 
                "tanggal" => "17 Apr 2026", 
                "ukm" => "UKM Seni",
                "event_nama" => "Traditional Dance Performance",
                "kategori_event" => "Hiburan",
                "tgl_event" => "25 Februari 2027",
                "deskripsi" => "Pertunjukan tarian tradisional dari berbagai daerah di Indonesia."
            ],
        ];

        // ================= DITOLAK =================
        $ditolak = [
            ["nama" => "Budi Santoso", "email" => "budi@gmail.com", "nim" => "2210112360", "ukm" => "HMTI", "alasan" => "Tidak memenuhi syarat"],
            ["nama" => "Citra Dewi", "email" => "citra@gmail.com", "nim" => "2210112361", "ukm" => "UKM Seni", "alasan" => "Data tidak lengkap"],
            ["nama" => "Eko Prasetyo", "email" => "eko@gmail.com", "nim" => "2210112362", "ukm" => "BEM", "alasan" => "Kuota penuh"],
            ["nama" => "Dewi Lestari", "email" => "dewi@gmail.com", "nim" => "2210112363", "ukm" => "UKM Olahraga", "alasan" => "Tidak hadir seleksi"],
            ["nama" => "Ahmad Fauzi", "email" => "ahmad@gmail.com", "nim" => "2210112364", "ukm" => "HMTI", "alasan" => "Dokumen tidak valid"],
        ];

        return view('pages.admin.panitia', compact('kelola', 'pengajuan', 'ditolak'));
    }
}
