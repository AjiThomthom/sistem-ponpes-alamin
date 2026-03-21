<?php

namespace App\Http\Controllers;

use App\Models\CmsMateriPustaka;
use Illuminate\Http\Request;

class MadingController extends Controller
{
    public function index()
    {
        // Ambil semua materi yang tidak dihapus (IsDeleted = 0)
        $mading = CmsMateriPustaka::where('IsDeleted', 0)
                    ->orderBy('CreatedDate', 'desc')
                    ->get();

        return view('mading-pustaka', compact('mading'));
    }
}