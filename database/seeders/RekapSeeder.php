<?php

namespace Database\Seeders;

use App\Models\Rekap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rekap = [
            [
                'tanggal' => '2023-01-01',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2023-01-02',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2023-01-03',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2023-01-04',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2023-01-05',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2023-01-06',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2023-01-07',
                'id_wisata' => 1,
                'wisatawan_domestik' => 100,
                'wisatawan_mancanegara' => 50,
                'total_pendapatan' => 1000000,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 1,
                'wisatawan_domestik' => 8127,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 16000000,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 2,
                'wisatawan_domestik' => 1314,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 2600000,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 3,
                'wisatawan_domestik' => 0,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 4,
                'wisatawan_domestik' => 86,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 500000,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 5,
                'wisatawan_domestik' => 116,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 600000,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 6,
                'wisatawan_domestik' => 368,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 1800000,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 7,
                'wisatawan_domestik' => 0,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
            [
                'tanggal' => '2022-12-17',
                'id_wisata' => 10,
                'wisatawan_domestik' => 602,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 1,
                'wisatawan_domestik' => 6115,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 12000000,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 2,
                'wisatawan_domestik' => 3596,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 6000000,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 3,
                'wisatawan_domestik' => 0,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 4,
                'wisatawan_domestik' => 0,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 5,
                'wisatawan_domestik' => 333,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 1800000,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 6,
                'wisatawan_domestik' => 713,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 3500000,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 7,
                'wisatawan_domestik' => 0,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
            [
                'tanggal' => '2022-11-18',
                'id_wisata' => 10,
                'wisatawan_domestik' => 1001,
                'wisatawan_mancanegara' => 0,
                'total_pendapatan' => 0,
            ],
        ];

        foreach ($rekap as $data) {
            Rekap::create($data);
        }
    }
}
