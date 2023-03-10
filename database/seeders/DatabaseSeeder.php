<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            KecamatanSeeder::class,
            WisataSeeder::class,
            TiketSeeder::class,
            UserSeeder::class,
            TransaksiSeeder::class,
            HotelSeeder::class,
            RekapHotelSeeder::class,
            RekapWisataSeeder::class,
        ]);
    }
}
