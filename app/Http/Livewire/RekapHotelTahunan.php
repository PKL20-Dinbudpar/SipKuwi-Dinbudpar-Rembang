<?php

namespace App\Http\Livewire;

use App\Models\Hotel;
use App\Models\Rekap;
use Livewire\Component;

class RekapHotelTahunan extends Component
{
    public $tahun;
    public $totalWisatawan;
    public $totalPendapatan;
    
    public function mount()
    {
        $this->tahun = date('Y');
    }

    public function render()
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
                
        return view('livewire.dinas.rekap-hotel-tahunan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'hotel' => $hotel,
        ]);
    }

    public function export()
    {
        // return Excel::download(new RekapTahunanExport($this->tahun), 'RekapHotelBulanan.xlsx');
    }
}
