<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SppController;
use App\Http\Controllers\MadingController;
use App\Models\TrxTagihanSpp;

// 1. Halaman Utama (Welcome)
Route::get('/', [SppController::class, 'welcome'])->name('welcome');

// 2. Halaman Cek SPP (WAJIB bernama spp.index agar tidak error 500)
Route::get('/cek-spp', [SppController::class, 'index'])->name('spp.index');

// 3. Halaman Mading Pustaka
Route::get('/mading-pustaka', [MadingController::class, 'index'])->name('mading.index');

// 4. Rute Cetak Tagihan (Mencari berdasarkan id_tagihan)
Route::get('/cetak/tagihan/{id}', function ($id) {
    $tagihan = TrxTagihanSpp::with('santri')->where('id_tagihan', $id)->firstOrFail();
    return view('cetak-spp', ['data' => $tagihan, 'jenis' => 'TAGIHAN SPP']);
});

// 5. Rute Cetak Kwitansi (Mencari berdasarkan id_tagihan)
Route::get('/cetak/kwitansi/{id}', function ($id) {
    $tagihan = TrxTagihanSpp::with('santri')->where('id_tagihan', $id)->firstOrFail();
    return view('cetak-spp', ['data' => $tagihan, 'jenis' => 'KWITANSI PEMBAYARAN']);
});