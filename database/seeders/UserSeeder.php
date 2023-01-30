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
                'username' => 'dinas',
                'password' => Hash::make('dinas'),
                'name' => 'Dinas',
                'email' => 'dinas@gmail.com',
                'alamat' => 'Jl. Dinas',
                'role' => 'dinas',
            ],
            [
                'username' => 'wisata',
                'password' => Hash::make('wisata'),
                'name' => 'Wisata',
                'email' => 'wisata@gmail.com',
                'alamat' => 'Jl. Wisata',
                'role' => 'wisata',
                'id_wisata' => 999,
            ],
            [
                'username' => 'hotel',
                'password' => Hash::make('hotel'),
                'name' => 'Hotel',
                'email' => 'hotel@gmail.com',
                'alamat' => 'Jl. Hotel',
                'role' => 'hotel',
                // 'id_hotel' => 999,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
