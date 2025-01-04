<?php

namespace App\Imports;

use App\Models\DataHistoriPT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class DataHistoriPTImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Normalisasi nama kolom dengan mengganti spasi dengan underscore
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = str_replace([' ', '.'], '_', strtolower(trim($key))); // Mengubah nama kolom "Kode PT" menjadi "kode_pt"
            $normalizedRow[$normalizedKey] = $value;
        }

        // Hanya ambil kolom Kode PT, Nama PT, Status, dan Keterangan
        $kodePt = trim($normalizedRow['kode_pt'] ?? '');
        $namaPt = trim($normalizedRow['nama_pt'] ?? '');
        $statusPt = trim($normalizedRow['status'] ?? '');
        $keterangan = trim($normalizedRow['keterangan'] ?? '');

        // Abaikan baris yang sepenuhnya kosong
        if (empty($kodePt) && empty($namaPt) && empty($statusPt) && empty($keterangan)) {
            return null; // Abaikan baris kosong
        }

        // Jika salah satu kolom kosong, maka berikan nilai "-" (hanya isi kolom yang kosong)
        $kodePt = !empty($kodePt) ? $kodePt : '-';
        $namaPt = !empty($namaPt) ? $namaPt : '-';
        $statusPt = !empty($statusPt) ? $statusPt : '-';

        // Logika pengisian kolom Keterangan berdasarkan Status
        if ($statusPt === 'Aktif') {
            $keterangan = null; // Jika status "Aktif", kolom keterangan dikosongkan
        } elseif (!empty($statusPt) && $statusPt !== 'Aktif') {
            $keterangan = !empty($keterangan) ? $keterangan : '-'; // Jika status bukan "Aktif" dan keterangan kosong, isi dengan "-"
        } else {
            $keterangan = '-'; // Jika status kosong, keterangan juga diisi "-"
        }

        // Buat model DataHistoriPT
        return new DataHistoriPT([
            'kode_pt' => $kodePt,
            'nama_pt' => $namaPt,
            'status_pt' => $statusPt,
            'keterangan' => $keterangan,
        ]);
    }
}
