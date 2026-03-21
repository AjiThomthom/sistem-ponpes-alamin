<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CmsMateriPustaka extends Model
{
    protected $table = 'cms_materi_pustaka';
    
    // Sesuaikan primary key dengan yang ada di database (tadi di SQL kita pakai 'id')
    protected $primaryKey = 'id'; 
    
    protected $guarded = [];

    // Mapping nama kolom timestamp agar sesuai standar dosen (CreatedDate & LastUpdatedDate)
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    protected static function boot()
    {
        parent::boot();

        // Otomatis mengisi field saat data DIBUAT
        static::creating(function ($model) {
            $model->id_user = Auth::id() ?? 1; // Menjaga field id_user tetap terisi
            $model->CreatedBy = Auth::user()->name ?? 'Admin Al-Amin';
            $model->CompanyCode = 'AL-AMIN';
            $model->Status = 1;
            $model->IsDeleted = 0;
            
            // Inisialisasi LastUpdatedDate agar tidak null di awal
            $model->LastUpdatedDate = now();
        });

        // Otomatis mengisi field saat data DIEDIT
        static::updating(function ($model) {
            // Jika dosen minta LastUpdatedBy, pastikan kolomnya ada di DB
            // $model->LastUpdatedBy = Auth::user()->name ?? 'System'; 
            
            $model->LastUpdatedDate = now();
        });
    }
}