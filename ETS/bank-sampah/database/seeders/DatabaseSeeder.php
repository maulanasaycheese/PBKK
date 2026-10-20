<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@banksampah.test'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'petugas@banksampah.test'],
            ['name' => 'Petugas', 'password' => Hash::make('password'), 'role' => 'petugas']
        );

        $this->call(JenisSampahSeeder::class);

        Nasabah::updateOrCreate(
            ['kode_nasabah' => 'NSB-0001'],
            ['nama' => 'Budi Santoso', 'alamat' => 'RT 03 RW 02', 'no_hp' => '081234567890', 'status' => 'aktif']
        );
        Nasabah::updateOrCreate(
            ['kode_nasabah' => 'NSB-0002'],
            ['nama' => 'Siti Aminah', 'alamat' => 'RT 03 RW 02', 'no_hp' => '081298765432', 'status' => 'aktif']
        );
    }
}
