<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index']);

use App\Http\Controllers\JenisTiketController;
Route::get('/jenistiket', [JenisTiketController::class, 'index']);

use App\Http\Controllers\ListEventController;
Route::get('/event', [ListEventController::class, 'index']);

use App\Http\Controllers\BarangController;
Route::get('/barang', [BarangController::class, 'tampilkan']);

