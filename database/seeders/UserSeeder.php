<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'kadinas',
                'password' => Hash::make('kadinas'),
                'name' => 'Kepala Dinas',
                'email' => 'kainas@gmail.com',
                'alamat' => 'Jl. Dinas',
                'role' => 'dinas',
            ],
            [
                'username' => 'dinas',
                'password' => Hash::make('dinas'),
                'name' => 'Pegawai Dinas',
                'email' => 'dinas@gmail.com',
                'alamat' => 'Jl. Dinas',
                'role' => 'dinas',
            ],
            [
                'username' => 'karangjahe',
                'password' => Hash::make('karangjahe'),
                'name' => 'Pengelola KJB',
                'email' => 'kjb@gmail.com',
                'alamat' => 'Ds. Punjulharjo',
                'role' => 'wisata',
                'id_wisata' => 1,
            ],
            [
                'username' => 'pantaiwates',
                'password' => Hash::make('pantaiwates'),
                'name' => 'Pengelola Wates',
                'email' => 'wates@gmail.com',
                'alamat' => 'Ds. Tasikharjo',
                'role' => 'wisata',
                'id_wisata' => 2,
            ],
            [
                'username' => 'hotelantika',
                'password' => Hash::make('hotelantika'),
                'name' => 'Pemilik Antika',
                'email' => 'antika@gmail.com',
                'alamat' => 'Jl. Airlangga No.17, Sumberjo',
                'role' => 'hotel',
                'id_hotel' => 1,
            ],
            [
                'username' => 'favehotel',
                'password' => Hash::make('favehotel'),
                'name' => 'Pemilik Fave',
                'email' => 'favehotel@gmail.com',
                'alamat' => 'Jl. Jend. Sudirman No.8, Kutoharjo, Pandean',
                'role' => 'hotel',
                'id_hotel' => 2,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
