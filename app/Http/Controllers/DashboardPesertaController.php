<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPesertaController extends Controller
{
    public function index()
    {
        return view('dashboard_peserta');
    }
}