<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample employee user
        $user = User::create([
            'username' => 'employee',
            'password' => Hash::make('password'),
            'role' => 'employee'
        ]);

        // Create sample employee
        Pegawai::create([
            'user_id' => $user->id,
            'nip' => '2025001',
            'nama_lengkap' => 'Budi Santoso',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-05-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'nomor_telepon' => '081234567890',
            'email' => 'budi.santoso@example.com',
            'status_pegawai' => 'aktif'
        ]);
    }
}
