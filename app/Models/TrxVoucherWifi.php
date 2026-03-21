<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrxVoucherWifi extends Model
{
    protected $table = 'trx_voucher_wifi';
    protected $primaryKey = 'id_transaksi';
    protected $guarded = [];

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

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

    public function santri()
    {
        return $this->belongsTo(MstSantri::class, 'nis', 'nis');
    }
}