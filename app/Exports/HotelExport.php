<?php

namespace App\Exports;

use App\Models\Hotel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HotelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Hotel::with('kecamatan')
                    ->select('hotel.id_hotel', 'hotel.nama_hotel', 'hotel.alamat', 'kecamatan.nama_kecamatan')
                    ->leftjoin('kecamatan', 'hotel.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                    ->get();
    }

    public function headings(): array
    {
        return ["id", "nama", "alamat", "kecamatan"];
    }
}
