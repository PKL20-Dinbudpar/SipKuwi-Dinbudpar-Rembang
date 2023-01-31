<?php

namespace App\Exports;

use App\Http\Livewire\RekapHotelBulanan;
use App\Models\Hotel;
use App\Models\Rekap;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class HotelBulananExport extends RekapHotelBulanan implements FromView
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
        $tanggal = Rekap::with('hotel')
                ->leftjoin('hotel', 'rekap.id_hotel', '=', 'hotel.id_hotel')
                ->select('tanggal')
                ->whereMonth('tanggal', '=', $this->bulan)
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('tanggal')
                ->get();
        
        $rekap = Rekap::with('hotel')
                ->join('hotel', 'rekap.id_hotel', '=', 'hotel.id_hotel')
                ->whereYear('tanggal', '=', $this->tahun)
                ->whereMonth('tanggal', '=', $this->bulan)
                ->get();
        
        $hotel = Hotel::all();


        return view('livewire.dinas.rekap-hotel-bulanan', [
            'tanggal' => $tanggal,
            'rekap' => $rekap,
            'hotel' => $hotel,
        ]);
    }
}
