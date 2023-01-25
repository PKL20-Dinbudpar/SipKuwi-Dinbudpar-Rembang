<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tes Admin Dinas
        Pengguna::create(
            [
                'username' => 'dinas',
                'password' => 'dinas',
                'nama' => 'Dinas',
                'role' => 'dinas',
            ],
        );

        // Tes Admin Wisata
        Pengguna::create(
            [
                'username' => 'wisata',
                'password' => 'wisata',
                'nama' => 'Wisata',
                'role' => 'wisata',
                'id_wisata' => 999,
            ],
        );
    }
}
