<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\HotelHarianExport;
use App\Models\Hotel;
use App\Models\RekapHotel;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapHotelHarian extends Component
{
    public $bulan;
    public $tahun;
    
    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
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


        return view('livewire.dinas.rekap-hotel-harian', [
            'tanggal' => $tanggal,
            'rekap' => $rekap,
            'hotel' => $hotel,
        ]);
    }

    public function export()
    {
        return Excel::download(new HotelHarianExport($this->bulan, $this->tahun), 'RekapHotelHarian' . $this->bulan . $this->tahun . '.xlsx');
    }
}
