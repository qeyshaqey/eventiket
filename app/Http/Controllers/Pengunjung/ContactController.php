<?php
namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ContactController extends Controller {
    public function index() { return view('pengunjung.contact'); }
    public function send(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'topic'   => 'required|string',
            'message' => 'required|string|min:10',
        ]);
        return back()->with('success', 'Pesan berhasil dikirim! Kami akan menghubungi kamu segera.');
    }
}
