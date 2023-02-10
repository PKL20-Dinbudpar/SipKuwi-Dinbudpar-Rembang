<?php

namespace App\Exports;

use App\Models\Hotel;
use App\Models\RekapHotel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HotelBulananExport implements FromView
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
        $bulan = RekapHotel::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->join('hotel', 'rekap_hotel.id_hotel', '=', 'hotel.id_hotel')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = RekapHotel::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(pengunjung_nusantara) pengunjung_nusantara, SUM(pengunjung_mancanegara) pengunjung_mancanegara, SUM(total_pendapatan) total_pendapatan')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_hotel', 'bulan', 'tahun')
                ->get();

        $hotel = Hotel::all();
                
        return view('components.tables.tabel-rekap-hotel-bulanan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'hotel' => $hotel,
        ]);
    }
}
