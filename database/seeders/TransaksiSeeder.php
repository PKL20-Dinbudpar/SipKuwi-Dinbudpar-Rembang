<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaksi = [
            [
                'waktu_transaksi' => '2023-01-01 00:00:00',
                'id_wisata' => 999,
                'id_user' => 999,
                'id_tiket' => 1,
                'jumlah_tiket' => 1,
                'total_pendapatan' => 5000,
            ],
            [
                'waktu_transaksi' => '2023-01-01 10:00:00',
                'id_wisata' => 999,
                'id_user' => 999,
                'id_tiket' => 1,
                'jumlah_tiket' => 3,
                'total_pendapatan' => 15000,
            ],
            [
                'waktu_transaksi' => '2023-01-02 00:00:00',
                'id_wisata' => 999,
                'id_user' => 999,
                'id_tiket' => 1,
                'jumlah_tiket' => 2,
                'total_pendapatan' => 10000,
            ],
            [
                'waktu_transaksi' => '2023-01-03 00:00:00',
                'id_wisata' => 999,
                'id_user' => 999,
                'id_tiket' => 1,
                'jumlah_tiket' => 2,
                'total_pendapatan' => 10000,
            ],
        ];

        foreach ($transaksi as $key => $value) {
            Transaksi::create($value);
        }
    }
}
