<?php

namespace App\Exports;

use App\Models\RekapWisata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KunjunganWisataExport implements FromCollection, WithHeadings
{
    public $idWisata;

    public function __construct($idWisata = null)
    {
        $this->idWisata = $idWisata;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $rekap = RekapWisata::select('tanggal', 'wisatawan_nusantara', 'wisatawan_mancanegara', 'total_pendapatan')
                    ->where('id_wisata', $this->idWisata ?? auth()->user()->id_wisata)
                    ->orderBy('tanggal', 'desc');

        return $rekap->get();
    }

    public function headings(): array
    {
        return ["tanggal", "wisatawan nusantara", "wisatawan mancanegara", "total pendapatan"];
    }
}
