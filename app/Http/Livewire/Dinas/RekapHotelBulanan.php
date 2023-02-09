<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\HotelBulananExport;
use App\Models\Hotel;
use App\Models\Rekap;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapHotelBulanan extends Component
{
    public $tahun;
    
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

        $rekap = Rekap::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_nusantara) wisatawan_nusantara, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(kamar_terjual) kamar_terjual')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_hotel', 'bulan', 'tahun')
                ->get();

        $hotel = Hotel::all();
                
        return view('livewire.dinas.rekap-hotel-bulanan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'hotel' => $hotel,
        ]);
    }

    public function export()
    {
        return Excel::download(new HotelBulananExport($this->tahun), 'RekapHotelBulanan' . $this->tahun . '.xlsx');
    }
}
