<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = [
            ["tanggal"=>"30 Mei","nama"=>"Seminar Forte"],
            ["tanggal"=>"15 Nov","nama"=>"Seminar Meraih Mimpi"],
        ];

        return view('kelola-event', compact('events'));
    }

    public function approve($id)
    {
        return redirect()->back();
    }

    public function delete($id)
    {
        return redirect()->back();
    }
}