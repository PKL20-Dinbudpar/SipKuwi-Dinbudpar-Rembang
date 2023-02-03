<?php

namespace App\Exports;

use App\Models\Rekap;
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
        $rekap = Rekap::select('tanggal', 'wisatawan_domestik', 'wisatawan_mancanegara', 'total_pendapatan')
                    ->where('id_wisata', $this->idWisata ?? auth()->user()->id_wisata)
                    ->orderBy('tanggal', 'desc');

        return $rekap->get();
    }

    public function headings(): array
    {
        return ["tanggal", "wisatawan domestik", "wisatawan mancanegara", "total pendapatan"];
    }
}
