<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PerguruanTinggiNegeri extends Model
{
    use HasFactory;

    protected $table = 'ptn';

    protected $fillable = [
        'kode_pt',
        'nama_pt',
        'uuid',
    ];

    /**
     * Boot method untuk menghasilkan UUID secara otomatis saat membuat data baru.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Ganti route key dengan UUID
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
