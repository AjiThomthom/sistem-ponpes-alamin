<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstAsatidz extends Model
{
    use HasFactory;

    protected $table = 'mst_asatidz';
    protected $primaryKey = 'id_asatidz';
    public $timestamps = false; // Kita matikan timestamp bawaan Laravel karena pakai field custom

    protected $guarded = [];

    // Relasi: Satu Ustadz bisa mengajar banyak jadwal
    public function jadwal()
    {
        return $this->hasMany(CmsJadwalPengajian::class, 'pengajar_id', 'id_asatidz');
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