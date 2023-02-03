<?php

namespace App\Exports;

use App\Models\Hotel;
use App\Models\Rekap;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class HotelTahunanExport implements FromView
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
        $bulan = Rekap::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->join('hotel', 'rekap.id_hotel', '=', 'hotel.id_hotel')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = Rekap::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_domestik) wisatawan_domestik, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(total_pendapatan) total_pendapatan')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_hotel', 'bulan', 'tahun')
                ->get();

        $hotel = Hotel::all();
                
        return view('components.tables.tabel-rekap-hotel-tahunan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'hotel' => $hotel,
        ]);
    }
}
