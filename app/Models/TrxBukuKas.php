<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrxBukuKas extends Model
{
    protected $table = 'trx_buku_kas';
    protected $primaryKey = 'id_kas';
    protected $guarded = [];

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->CreatedBy = Auth::user()->name ?? 'System';
            $model->CompanyCode = 'AL-AMIN';
            $model->Status = 1;
            $model->IsDeleted = 0;
        });
        static::updating(fn ($model) => $model->LastUpdatedBy = Auth::user()->name ?? 'System');
    }
}