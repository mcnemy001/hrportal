<?php

namespace Database\Seeders;

use App\Models\Kontrak;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class KontrakSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = Pegawai::first();

        if ($pegawai) {
            Kontrak::create([
                'pegawai_id' => $pegawai->id,
                'nomor_kontrak' => '2025/HRD/001',
                'gaji_pokok' => 5000000,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_berakhir' => '2025-12-31',
                'status' => 'active',
                'keterangan' => 'Kontrak awal'
            ]);
        }
    }
}
