<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth; // Wajib ada ini!

class MstSantri extends Model
{
    use SoftDeletes;

    protected $table = 'mst_santri';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    // 1. Hubungkan Timestamps Laravel ke Field Wajib Dosen
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';
    const DELETED_AT = 'DeletedDate';

    // 2. Fungsi Ajaib untuk mengisi 7 Field Otomatis
    protected static function boot()
    {
        parent::boot();

        // Saat data akan dibuat (Create)
        static::creating(function ($model) {
            $model->CreatedBy = Auth::user()->name ?? 'System'; // Ambil nama admin yang login
            $model->CompanyCode = 'AL-AMIN';
            $model->Status = 1;
            $model->IsDeleted = 0;
        });

        // Saat data akan diubah (Update)
        static::updating(function ($model) {
            $model->LastUpdatedBy = Auth::user()->name ?? 'System';
        });

        // Saat data akan dihapus (Soft Delete)
        static::deleting(function ($model) {
            $model->DeletedBy = Auth::user()->name ?? 'System';
            $model->IsDeleted = 1;
            $model->save();
        });
    }
}