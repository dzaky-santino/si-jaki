<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaporanPTN extends Model
{
    use HasFactory;

    protected $table = 'laporan_ptn';

    protected $fillable = [
        'uuid',
        'ptn_id',
        'user_id',
        'jenis_kegiatan',
        'tanggal_kegiatan',
        'tempat_kegiatan',
        'dokumen_notula',
        'dokumen_undangan',
        'resume',
        'status',
        'createdbyuser',
        'pokja',
    ];

    protected $casts = [
        'pokja' => 'array',  // Ini akan mengonversi kolom pokja menjadi array
    ];

    protected static function boot()
    {
        parent::boot();
        // Generate UUID saat data baru dibuat
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid'; // Gunakan UUID untuk route binding
    }

    public function ptn()
    {
        return $this->belongsTo(PerguruanTinggiNegeri::class, 'ptn_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
