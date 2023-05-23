<?php

namespace App\Exports;

use App\Models\RekapWisata;
use App\Models\Wisata;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WisataBulananExport implements FromView
{
    public $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $bulan = RekapWisata::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->join('wisata', 'rekap_wisata.id_wisata', '=', 'wisata.id_wisata')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = RekapWisata::selectRaw('id_wisata, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_nusantara) wisatawan_nusantara, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(total_pendapatan) total_pendapatan')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_wisata', 'bulan', 'tahun')
                ->get();

        $wisata = Wisata::all();

        return view('components.tables.tabel-rekap-wisata-bulanan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'wisata' => $wisata,]
        );
    }
}
