<?php

namespace App\Exports;

use App\Models\RekapWisata;
use App\Models\Wisata;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WisataHarianExport implements FromView
{
    public $bulan;
    public $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $tanggal = RekapWisata::with('wisata')
                ->join('wisata', 'rekap_wisata.id_wisata', '=', 'wisata.id_wisata')
                ->select('tanggal')
                ->whereMonth('tanggal', '=', $this->bulan)
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('tanggal')
                ->get();
        
        $rekap = RekapWisata::with('wisata')
                ->join('wisata', 'rekap_wisata.id_wisata', '=', 'wisata.id_wisata')
                ->whereYear('tanggal', '=', $this->tahun)
                ->whereMonth('tanggal', '=', $this->bulan)
                ->get();
        
        $wisata = Wisata::all();

        return view('components.tables.tabel-rekap-wisata-harian', [
            'rekap' => $rekap,
            'tanggal' => $tanggal,
            'wisata' => $wisata,]
        );
    }
}
