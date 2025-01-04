<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerguruanTinggiNegeri;

class PerguruanTinggiNegeriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerguruanTinggiNegeri::create([
            'kode_pt' => '654321',
            'nama_pt' => 'Universitas Mantab',
        ]);
    }
}
