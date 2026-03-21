<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrxTagihanSpp extends Model
{
    // Nama tabel di MariaDB
    protected $table = 'trx_tagihan_spp';
    
    // Primary Key tabel
    protected $primaryKey = 'id_tagihan';
    
    // Membolehkan semua field diisi (Mass Assignment)
    protected $guarded = [];

    // Pemetaan 7 Field Wajib Dosen (Audit Trail)
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    /**
     * Casting data agar field tanggal bisa dimanipulasi dengan mudah.
     * Ini WAJIB agar fitur Trace Pembayaran di Frontend tidak Error.
     */
    protected $casts = [
        'tanggal_lunas' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    /**
     * Boot function untuk menangani logika otomatis (7 Field Wajib).
     */
    protected static function boot()
    {
        parent::boot();

        // Otomatis isi field saat data tagihan BARU dibuat
        static::creating(function ($model) {
            $model->CreatedBy = Auth::user()->name ?? 'System';
            $model->CompanyCode = 'AL-AMIN';
            $model->Status = 1;
            $model->IsDeleted = 0;
        });

        // Otomatis isi field saat data tagihan DIUBAH (Misal saat bayar/lunas)
        static::updating(function ($model) {
            $model->LastUpdatedBy = Auth::user()->name ?? 'System';
        });
    }

    /**
     * Relasi ke Tabel Master Santri (One-to-Many Inverse).
     * Setiap tagihan pasti dimiliki oleh satu santri.
     */
    public function santri()
    {
        return $this->belongsTo(MstSantri::class, 'nis', 'nis');
    }
}