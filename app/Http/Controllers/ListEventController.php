<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListEventController extends Controller
{
    public function index()
    {
        return view('list_event');
    }
}