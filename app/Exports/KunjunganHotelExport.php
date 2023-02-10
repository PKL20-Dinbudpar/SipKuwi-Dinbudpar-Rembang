<?php

namespace App\Exports;

use App\Models\RekapHotel;
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
        $rekap = RekapHotel::select('tanggal', 'pengunjung_nusantara', 'pengunjung_mancanegara', 'kamar_terjual')
                    ->where('id_hotel', $this->idHotel ?? auth()->user()->id_hotel)
                    ->orderBy('tanggal', 'desc');

        return $rekap->get();
    }

    public function headings(): array
    {
        return ["tanggal", "pengunjung nusantara", "pengunjung mancanegara", "kamar terjual"];
    }
}
