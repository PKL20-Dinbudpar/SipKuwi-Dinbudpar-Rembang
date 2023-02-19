<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('wisata', 'hotel')
                    ->selectRaw('users.id, users.name, users.username, users.email, users.role, IF(users.id_wisata IS NULL, hotel.nama_hotel, wisata.nama_wisata) as tempat')
                    ->leftjoin('wisata', 'users.id_wisata', '=', 'wisata.id_wisata')
                    ->leftjoin('hotel', 'users.id_hotel', '=', 'hotel.id_hotel')
                    ->orderBy('role', 'asc')
                    ->get();
    }

    public function headings(): array
    {
        return ["id", "nama", "username", "email", "role", "tempat"];
    }
}