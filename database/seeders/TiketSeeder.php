<?php

namespace Database\Seeders;

use App\Models\Tiket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tiket::create(
            [
                'id_wisata' => 999,
                'nama_tiket' => 'Tiket Wisata',
                'harga' => 10000,
                'deskripsi' => 'Tiket Wisata',
            ],);
    }
}
