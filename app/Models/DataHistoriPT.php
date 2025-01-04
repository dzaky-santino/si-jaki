<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;  // Import Str facade untuk UUID

class DataHistoriPT extends Model
{
    use HasFactory;
    
    protected $table = 'data_histori_pt';
    protected $fillable = ['kode_pt', 'nama_pt', 'status_pt', 'keterangan', 'uuid'];

    protected static function booted()
    {
        static::creating(function ($model) {
            // Generate UUID otomatis ketika data baru akan dibuat
            $model->uuid = Str::uuid()->toString();
        });
    }
}
