<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use Illuminate\Database\Seeder;

class JenisSampahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Botol plastik PET',   'plastik', 3000],
            ['Gelas plastik (PP)',  'plastik', 2500],
            ['Kardus',              'kertas',  1800],
            ['Kertas HVS/buku',     'kertas',  2000],
            ['Kaleng aluminium',    'logam',   9000],
            ['Besi/seng',           'logam',   3500],
            ['Botol kaca',          'kaca',     500],
        ];

        foreach ($data as [$nama, $kategori, $harga]) {
            JenisSampah::updateOrCreate(
                ['nama' => $nama],
                ['kategori' => $kategori, 'harga_per_kg' => $harga, 'aktif' => true]
            );
        }
    }
}
