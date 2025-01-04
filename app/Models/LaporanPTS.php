<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaporanPTS extends Model
{
    use HasFactory;

    protected $table = 'laporan_pts';

    protected $fillable = [
        'uuid',
        'pts_id',
        'user_id',
        'jenis_kegiatan',
        'tanggal_kegiatan',
        'tempat_kegiatan',
        'dokumen_notula',
        'dokumen_undangan',
        'resume',
        'status',
        'createdbyuser',
        'pokja', // Tambahkan pokja di sini
    ];

    // Menambahkan cast untuk kolom pokja agar disimpan sebagai array
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

    public function pts()
    {
        return $this->belongsTo(PerguruanTinggiSwasta::class, 'pts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
