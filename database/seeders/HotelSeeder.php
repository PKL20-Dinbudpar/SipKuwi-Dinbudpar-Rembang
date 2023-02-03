<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = [
            [
                'nama_hotel' => 'Hotel Antika',
                'alamat' => 'Jl. Airlangga No.17, Sumberjo',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Fave',
                'alamat' => 'Jl. Jend. Sudirman No.8, Kutoharjo, Pandean',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Gajah Mada',
                'alamat' => 'Jl. Gajah Mada No.6, Banyudono, Pantiharjo',
                'id_kecamatan' => '90',
            ],
            [
                'nama_hotel' => 'Hotel Kartini',
                'alamat' => 'Jalan Gajah Mada No.6, Karangturi, Banyudono',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Kencana',
                'alamat' => 'Jl. Diponegoro No.79, Kutoharjo',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Larasati',
                'alamat' => 'Jl. Jend. Sudirman No.3, Kutoharjo',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Pantura',
                'alamat' => 'Jl. Gajah Mada No.1, Banyudono',
                'id_kecamatan' => '90',
            ],
            [
                'nama_hotel' => 'Hotel Pollos',
                'alamat' => 'Jl. Jend. Sudirman No.,. 158, Kabongan Lor',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Puri Indah',
                'alamat' => 'Jl. Pemuda No.KM 03, Purimondoteko, Mondoteko',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Rantina',
                'alamat' => ' Jl. Gatot Subroto No.5, Kutoharjo',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Lasem Boutique',
                'alamat' => 'Jl. Karangturi, Mahbong, Karangturi',
                'id_kecamatan' => '140',
            ],
            [
                'nama_hotel' => 'Hotel Dua Putri II / Al Mina',
                'alamat' => 'Ds. Rejomulyo, Pasarbanggi',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Tiara',
                'alamat' => 'Jl. Gajah Mada No.Km.5, Karangturi, Banyudono',
                'id_kecamatan' => '100',
            ],
            [
                'nama_hotel' => 'Hotel Surya',
                'alamat' => 'Jl. Untung Suropati No.9, Pabeyan Kulon, Dorokandang',
                'id_kecamatan' => '140',
            ],
            [
                'nama_hotel' => 'Hotel Malindo',
                'alamat' => 'Area Sawah/Kebun, Sluke',
                'id_kecamatan' => '130',
            ],

            [   
                'id_hotel' => 999,
                'nama_hotel' => 'Tes Hotel',
            ],
        ];

        foreach ($hotel as $key => $value) {
            Hotel::class::create($value);
        }
    }
}
