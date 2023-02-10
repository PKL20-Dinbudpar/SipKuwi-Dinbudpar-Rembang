<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\WisataHarianExport;
use App\Models\RekapWisata;
use App\Models\Wisata;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapWisataHarian extends Component
{
    public $bulan;
    public $tahun;
    public $totalWisatawan;
    public $totalPendapatan;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $tanggal = RekapWisata::with('wisata')
                ->join('wisata', 'rekap_wisata.id_wisata', '=', 'wisata.id_wisata')
                ->select('tanggal')
                ->whereMonth('tanggal', '=', $this->bulan)
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('tanggal')
                ->get();
        
        $rekap = RekapWisata::with('wisata')
                ->join('wisata', 'rekap_wisata.id_wisata', '=', 'wisata.id_wisata')
                ->whereYear('tanggal', '=', $this->tahun)
                ->whereMonth('tanggal', '=', $this->bulan)
                ->get();
        
        $wisata = Wisata::all();


        return view('livewire.dinas.rekap-wisata-harian', [
            'tanggal' => $tanggal,
            'rekap' => $rekap,
            'wisata' => $wisata,
        ]);
    }

    public function export()
    {
        return Excel::download(new WisataHarianExport($this->bulan, $this->tahun), 'RekapWisataHarian' . $this->bulan . $this->tahun . '.xlsx');
    }
}
