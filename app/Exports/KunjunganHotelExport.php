<?php

namespace App\Exports;

use App\Models\Rekap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KunjunganHotelExport implements FromCollection, WithHeadings
{
    public $idHotel;

    public function __construct($idHotel = null)
    {
        $this->idHotel = $idHotel;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $rekap = Rekap::select('tanggal', 'wisatawan_domestik', 'wisatawan_mancanegara', 'total_pendapatan')
                    ->where('id_hotel', $this->idHotel ?? auth()->user()->id_hotel)
                    ->orderBy('tanggal', 'desc');

        return $rekap->get();
    }

    public function headings(): array
    {
        return ["tanggal", "pengunjung domestik", "pengunjung mancanegara", "total pendapatan"];
    }
}
