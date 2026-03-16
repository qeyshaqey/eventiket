<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JenisTiketController extends Controller
{
    public function index()
    {
        return view('jenis_tiket');
    }
}
