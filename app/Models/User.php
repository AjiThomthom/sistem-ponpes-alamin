<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'CompanyCode',
        'Status',
        'IsDeleted',
        'CreatedBy',
        'LastUpdatedBy',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- LOGIKA 7 FIELD WAJIB DOSEN ---

    // 1. Hubungkan timestamp bawaan Laravel ke kolom database dosenmu
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    protected static function boot()
    {
        parent::boot();

        // 2. Otomatis isi field saat data USER baru dibuat
        static::creating(function ($model) {
            $model->CompanyCode = 'AL-AMIN';
            $model->Status = 1;
            $model->IsDeleted = 0;
            
            // Jika ada user login yang membuatkan akun ini, catat namanya. 
            // Jika tidak (misal via Tinker), isi 'System'.
            $model->CreatedBy = Auth::check() ? Auth::user()->name : 'System';
        });

        // 3. Otomatis isi field saat data USER diupdate
        static::updating(function ($model) {
            $model->LastUpdatedBy = Auth::check() ? Auth::user()->name : 'System';
        });
    }
}