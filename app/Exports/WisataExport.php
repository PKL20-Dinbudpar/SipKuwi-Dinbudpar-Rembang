<?php

namespace App\Exports;

use App\Models\Wisata;
use Maatwebsite\Excel\Concerns\FromCollection;

class WisataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Wisata::with('kecamatan')
                    ->select('wisata.id_wisata', 'wisata.nama_wisata', 'wisata.alamat', 'kecamatan.nama_kecamatan')
                    ->leftjoin('kecamatan', 'wisata.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                    ->get();
    }
}
