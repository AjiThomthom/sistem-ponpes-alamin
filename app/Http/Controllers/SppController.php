<?php

namespace App\Http\Controllers;

use App\Models\MstSantri;
use App\Models\TrxTagihanSpp;
use App\Models\CmsMateriPustaka;
use Illuminate\Http\Request;

class SppController extends Controller
{
    // Menampilkan Landing Page (Welcome)
    public function welcome()
    {
        $mading = CmsMateriPustaka::where('IsDeleted', 0)
                    ->orderBy('CreatedDate', 'desc')
                    ->take(3)
                    ->get();

        return view('welcome', compact('mading'));
    }

    // Menampilkan Halaman Cek SPP
    public function index(Request $request)
    {
        $santri = null;
        $tagihan = [];
        
        $mading = CmsMateriPustaka::where('IsDeleted', 0)
                    ->orderBy('CreatedDate', 'desc')
                    ->take(3)
                    ->get();

        if ($request->has('nis') && $request->nis != '') {
            $santri = MstSantri::where('nis', $request->nis)->first();
            
            if ($santri) {
                $tagihan = TrxTagihanSpp::where('nis', $request->nis)
                            ->orderBy('id_tagihan', 'desc')
                            ->get();
            }
        }

        return view('cek-spp', compact('santri', 'tagihan', 'mading'));
    }
}