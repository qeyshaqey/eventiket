<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisTiketController;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/jenistiket', [JenisTiketController::class, 'index']);

use App\Http\Controllers\ListEventController;

Route::get('/event', [ListEventController::class, 'index']);