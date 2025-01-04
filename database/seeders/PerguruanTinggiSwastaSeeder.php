<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerguruanTinggiSwasta;

class PerguruanTinggiSwastaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerguruanTinggiSwasta::create([
            'kode_pt' => '123456',
            'nama_pt' => 'Universitas Keren',
        ]);
    }
}
