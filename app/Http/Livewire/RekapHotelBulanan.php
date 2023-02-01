<?php

namespace App\Http\Livewire;

use App\Exports\HotelBulananExport;
use App\Models\Hotel;
use App\Models\Rekap;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapHotelBulanan extends Component
{
    public $bulan;
    public $tahun;
    public $totalPengunjung;
    public $totalPendapatan;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $tanggal = Rekap::with('hotel')
                ->join('hotel', 'rekap.id_hotel', '=', 'hotel.id_hotel')
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

    public function export()
    {
        return Excel::download(new HotelBulananExport($this->bulan, $this->tahun), 'RekapBulanan.xlsx');
    }
}