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
        return User::with('wisata')
                    ->select('users.id', 'users.name', 'users.username', 'users.email', 'users.pass', 'users.role', 'wisata.nama_wisata', 'hotel.nama_hotel')
                    ->leftjoin('wisata', 'users.id_wisata', '=', 'wisata.id_wisata')
                    ->leftjoin('hotel', 'users.id_hotel', '=', 'hotel.id_hotel')
                    ->orderBy('role', 'asc')
                    ->get();
    }

    public function headings(): array
    {
        return ["id", "nama", "username", "email", "password", "role", "wisata", "hotel"];
    }
}