<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisTiketController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/jenistiket', [JenisTiketController::class, 'index']);