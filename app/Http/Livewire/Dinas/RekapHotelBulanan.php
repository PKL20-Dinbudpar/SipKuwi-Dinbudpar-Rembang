<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\HotelBulananExport;
use App\Models\Hotel;
use App\Models\RekapHotel;
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
        $bulan = RekapHotel::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->join('hotel', 'rekap_hotel.id_hotel', '=', 'hotel.id_hotel')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = RekapHotel::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(pengunjung_nusantara) pengunjung_nusantara, SUM(pengunjung_mancanegara) pengunjung_mancanegara, SUM(kamar_terjual) kamar_terjual')
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
