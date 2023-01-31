<?php

namespace App\Exports;

use App\Models\Wisata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WisataExport implements FromCollection, WithHeadings
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

    public function headings(): array
    {
        return ["id", "nama", "alamat", "kecamatan"];
    }
}
