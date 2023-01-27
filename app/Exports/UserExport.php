<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('wisata')
                    ->select('users.id', 'users.name', 'users.username', 'users.email', 'users.password', 'wisata.nama_wisata')
                    ->leftjoin('wisata', 'users.id_wisata', '=', 'wisata.id_wisata')
                    ->get();
    }
}