<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SppController;
use App\Http\Controllers\MadingController;

// Jalur SPP & Welcome
Route::get('/', [SppController::class, 'welcome'])->name('welcome');
Route::get('/cek-spp', [SppController::class, 'index'])->name('spp.index');

// Jalur Khusus Mading Pustaka (Halaman Berbeda)
Route::get('/mading-pustaka', [MadingController::class, 'index'])->name('mading.index');