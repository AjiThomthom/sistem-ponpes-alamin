<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsJadwalPengajian extends Model
{
    use HasFactory;

    protected $table = 'cms_jadwal_pengajian';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $guarded = [];

    // Relasi: Jadwal ini diajar oleh satu Ustadz
    public function pengajar()
    {
        return $this->belongsTo(MstAsatidz::class, 'pengajar_id', 'id_asatidz');
    }

    // Fungsi otomatis untuk 7 Field Wajib Dosen
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->CreatedBy = auth()->user()->name ?? 'System Admin';
            $model->CreatedDate = now();
            $model->LastUpdatedBy = auth()->user()->name ?? 'System Admin';
            $model->LastUpdatedDate = now();
            $model->CompanyCode = 'Pondok Pesantren Al-Amin Cikarang Utara';
            $model->Status = 1;
            $model->IsDeleted = 0;
        });

        static::updating(function ($model) {
            $model->LastUpdatedBy = auth()->user()->name ?? 'System Admin';
            $model->LastUpdatedDate = now();
        });
    }
}