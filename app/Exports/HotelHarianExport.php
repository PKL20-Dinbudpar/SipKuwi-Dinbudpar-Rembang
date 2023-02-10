<?php

namespace App\Exports;

use App\Models\Hotel;
use App\Models\RekapHotel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HotelHarianExport implements FromView
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
        $tanggal = RekapHotel::with('hotel')
                ->join('hotel', 'rekap_hotel.id_hotel', '=', 'hotel.id_hotel')
                ->select('tanggal')
                ->whereMonth('tanggal', '=', $this->bulan)
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('tanggal')
                ->get();
        
        $rekap = RekapHotel::with('hotel')
                ->join('hotel', 'rekap_hotel.id_hotel', '=', 'hotel.id_hotel')
                ->whereYear('tanggal', '=', $this->tahun)
                ->whereMonth('tanggal', '=', $this->bulan)
                ->get();
        
        $hotel = Hotel::all();

        return view('components.tables.tabel-rekap-hotel-harian', [
            'tanggal' => $tanggal,
            'rekap' => $rekap,
            'hotel' => $hotel,
        ]);
    }
}
